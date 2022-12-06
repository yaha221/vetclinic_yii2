<?php

namespace nkostadinov\user\validators;

use nkostadinov\user\validators\UserAsset;
use nkostadinov\user\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\validators\Validator;

/**
 * Validates a password for the correct strength.
 *
 * @author ntraykov
 */
class PasswordStrengthValidator extends Validator
{
    /* The valid preset constants */
    const SIMPLE = 'simple';
    const NORMAL = 'normal';
    const FAIR = 'fair';
    const MEDIUM = 'medium';
    const STRONG = 'strong';

    /* The available rule constants */
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_LEN = 'length';
    const RULE_USER = 'hasUser';
    const RULE_EMAIL = 'hasEmail';
    const RULE_LOW = 'lower';
    const RULE_UP = 'upper';
    const RULE_NUM = 'digit';
    const RULE_SPL = 'special';
    
    /** @var array the default rule settings */
    private static $_rules = [
        self::RULE_MIN => [
            'msg' => '{attribute} should contain at least {n, plural, one{one character} other{# characters}} ({found} found)!',
            'int' => true
        ],
        self::RULE_MAX => [
            'msg' => '{attribute} should contain at most {n, plural, one{one character} other{# characters}} ({found} found)!',
            'int' => true
        ],
        self::RULE_LEN => [
            'msg' => '{attribute} should contain exactly {n, plural, one{one character} other{# characters}} ({found} found)!',
            'int' => true
        ],
        self::RULE_USER => [
            'msg' => '{attribute} cannot contain the username',
            'bool' => true
        ],
        self::RULE_EMAIL => [
            'msg' => '{attribute} cannot contain an email address',
            'match' => '/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i',
            'bool' => true
        ],
        self::RULE_LOW => [
            'msg' => '{attribute} should contain at least {n, plural, one{one lower case character} other{# lower case characters}} ({found} found)!',
            'match' => '![a-z]!',
            'int' => true
        ],
        self::RULE_UP => [
            'msg' => '{attribute} should contain at least {n, plural, one{one upper case character} other{# upper case characters}} ({found} found)!',
            'match' => '![A-Z]!',
            'int' => true
        ],
        self::RULE_NUM => [
            'msg' => '{attribute} should contain at least {n, plural, one{one numeric / digit character} other{# numeric / digit characters}} ({found} found)!',
            'match' => '![\d]!',
            'int' => true
        ],
        self::RULE_SPL => [
            'msg' => '{attribute} should contain at least {n, plural, one{one special character} other{# special characters}} ({found} found)!',
            'match' => '![\W]!',
            'int' => true
        ]
    ];
    
    /** @var boolean check whether password contains the username */
    public $hasUser = true;
    /** @var boolean check whether password contains an email string */
    public $hasEmail = true;
    /** @var int minimum number of characters. If not set, defaults to 6. */
    public $min = 6;
    /** @var int maximum length. If not set, it means no maximum length limit. */
    public $max;
    /** @var int specifies the exact length that the value should be of */
    public $length;
    /** @var int minimal number of lower case characters */
    public $lower = 2;
    /** @var int minimal number of upper case characters */
    public $upper = 2;
    /** @var int  minimal number of numeric digit characters */
    public $digit = 2;
    /** @var int minimal number of special characters */
    public $special = 2;
    /** @var string the name of the username attribute */
    public $userAttribute = 'username';
    /** @var string user-defined error message used when the value is not a string */
    public $strError;
    /** @var string user-defined error message used when the length of the value is smaller than [[min]]. */
    public $minError;
    /** @var string user-defined error message used when the length of the value is greater than [[max]]. */
    public $maxError;
    /** @var string user-defined error message used when the length of the value is not equal to [[length]]. */
    public $lengthError;
    /** @var string user-defined error message used when [[hasUser]] is true and value contains the username */
    public $hasUserError;
    /** @var string user-defined error message used [[hasEmail]] is true and value contains an email */
    public $hasEmailError;
    /** @var string user-defined error message used when value contains less than [[lower]] characters */
    public $lowerError;
    /** @var string user-defined error message used when value contains less than [[upper]] characters */
    public $upperError;
    /** @var string user-defined error message used when value contains less than [[digit]] characters */
    public $digitError;
    /** @var string user-defined error message used when value contains more than [[special]] characters */
    public $specialError;
    /**
     * If this is not null, the preset parameters will override the validator level params.
     * @var string preset One of the preset constants.
     */
    public $preset;
    /** @var array the list of inbuilt presets and their parameter settings */
    private $_presets = [
        self::SIMPLE => [
            'min' => 6,
            'upper' => 0,
            'lower' => 1,
            'digit' => 1,
            'special' => 0,
            'hasUser' => false,
            'hasEmail' => false
        ],
        self::NORMAL => [
            'min' => 6,
            'upper' => 1,
            'lower' => 1,
            'digit' => 1,
            'special' => 1,
            'hasUser' => false,
            'hasEmail' => true
        ],
        self::FAIR => [
            'min' => 8,
            'upper' => 1,
            'lower' => 1,
            'digit' => 1,
            'special' => 1,
            'hasUser' => true,
            'hasEmail' => true
        ],
        self::MEDIUM => [
            'min' => 10,
            'upper' => 1,
            'lower' => 1,
            'digit' => 2,
            'special' => 1,
            'hasUser' => true,
            'hasEmail' => true
        ],
        self::STRONG => [
            'min' => 12,
            'upper' => 2,
            'lower' => 2,
            'digit' => 2,
            'special' => 2,
            'hasUser' => true,
            'hasEmail' => true
        ],
    ];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->applyPreset();
        $this->checkParams();
        $this->setRuleMessages();
    }
    
    /**
     * Apply preset parameter if set
     *
     * @return void
     * @throws InvalidConfigException if [[preset]] value is invalid.
     */
    protected function applyPreset()
    {
        if (!isset($this->preset)) {
            return;
        }        
        if (array_key_exists($this->preset, $this->_presets)) {
            foreach ($this->_presets[$this->preset] as $param => $value) {
                $this->$param = $value;
            }
        } else {
            throw new InvalidConfigException("Invalid preset '{$this->preset}'.");
        }
    }
    
    /**
     * Validates the provided parameters for valid data type
     * and the right threshold for 'max' chars.
     *
     * @throw InvalidConfigException if validation is invalid
     */
    protected function checkParams()
    {
        foreach (self::$_rules as $rule => $setup) {
            if (isset($this->$rule) && !empty($setup['int']) && $setup['int'] &&
                (!is_int($this->$rule) || $this->$rule < 0)
            ) {
                throw new InvalidConfigException("The property '{$rule}' must be a positive integer.");
            }
            if (isset($this->$rule) && !empty($setup['bool']) && $setup['bool'] &&
                !is_bool($this->$rule)
            ) {
                throw new InvalidConfigException("The property '{$rule}' must be either true or false.");
            }
        }
        if (isset($this->max)) {
            $chars = $this->lower + $this->upper + $this->digit + $this->special;
            if ($chars > $this->max) {
                throw new InvalidConfigException("Total number of required characters {$chars} is greater than maximum allowed {$this->max}. Validation is impossible!");
            }
        }
    }
    
    /**
     * Sets the rule message for each rule
     */
    protected function setRuleMessages()
    {
        if ($this->strError === null) {
            $this->strError = Yii::t(Module::I18N_CATEGORY, '{attribute} must be a string');
        }
        foreach (self::$_rules as $rule => $setup) {
            $param = "{$rule}Error";
            if ($this->$rule !== null) {
                $message = (!isset($this->$param) || $this->$param === null) ? $setup['msg'] : $this->$param;
                $this->$param = Yii::t(Module::I18N_CATEGORY, $message, ['n' => $this->$rule]);
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = Html::getAttributeValue($model, $attribute);
        if (!is_string($value)) {
            $this->addError($model, $attribute, $this->strError);
            return;
        }
        $label = $model->getAttributeLabel($attribute);
        $username = $this->hasUser ? Html::getAttributeValue($model, $this->userAttribute) : '';
        $temp = [];
        foreach (self::$_rules as $rule => $setup) {
            $param = "{$rule}Error";
            if ($rule === self::RULE_USER && $this->hasUser && !empty($value) && !empty($username) && strpos($value, $username) !== false) {
                $this->addError($model, $attribute, $this->$param, ['attribute' => $label]);
            } elseif ($rule === self::RULE_EMAIL && $this->hasEmail && preg_match($setup['match'], $value, $matches)) {
                $this->addError($model, $attribute, $this->$param, ['attribute' => $label]);
            } elseif (!empty($setup['match']) && $rule !== self::RULE_EMAIL && $rule !== self::RULE_USER) {
                $count = preg_match_all($setup['match'], $value, $temp);
                if ($count < $this->$rule) {
                    $this->addError(
                        $model, $attribute, $this->$param, [
                            'attribute' => $label,
                            'found' => $count
                        ]
                    );
                }
            } else {
                $length = strlen($value);
                $test = false;
                if ($rule === self::RULE_LEN) {
                    $test = ($length !== $this->$rule);
                } elseif ($rule === self::RULE_MIN) {
                    $test = ($length < $this->$rule);
                } elseif ($rule === self::RULE_MAX) {
                    $test = ($length > $this->$rule);
                }
                if ($this->$rule !== null && $test) {
                    $this->addError(
                        $model, $attribute, $this->$param, [
                            'attribute' => $label . ' (' . $rule . ' , ' . $this->$rule . ')',
                            'found' => $length
                        ]
                    );
                }
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $label = $model->getAttributeLabel($attribute);
        $options = ['strError' => Html::encode(Yii::t(Module::I18N_CATEGORY, $this->message, ['attribute' => $label]))];
        $options['userField'] = '#' . Html::getInputId($model, $this->userAttribute);
        foreach (self::$_rules as $rule => $setup) {
            $param = "{$rule}Error";
            if ($this->$rule !== null) {
                $options[$rule] = $this->$rule;
                $options[$param] = Html::encode(Yii::t(Module::I18N_CATEGORY, $this->$param, ['attribute' => $label]));
            }
        }

        UserAsset::register($view);
        return "passwordStrengthValidator.validate(value, messages, " . Json::encode($options) . ");";
    }
}
