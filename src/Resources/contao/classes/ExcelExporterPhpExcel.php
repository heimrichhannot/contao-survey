<?php

namespace Hschottm\SurveyBundle;

use Hschottm\SurveyBundle\ExcelExporter;
use Hschottm\ExcelXLSBundle\xlsexport;

class ExcelExporterPhpExcel extends ExcelExporter
{
  public function __construct($type = self::EXPORT_TYPE_XLS)
  {
    parent::__construct($type);
  }

  public function createSpreadsheet()
  {
    $this->spreadsheet = new xlsexport();
  }

  public function setCellValue($sheet, $row, $col, $data)
  {
    if (array_key_exists($sheet, $this->sheets))
    {
      $celldata = array(
        self::ROW => $row,
        self::COL => $col
      );
      foreach ($data as $key => $value)
      {
        $celldata[$key] = $value;
      }
      if (!array_key_exists(self::CELLTYPE, $celldata)) $celldata[self::CELLTYPE] = self::CELLTYPE_STRING;
      if ($celldata[self::CELLTYPE] === self::CELLTYPE_STRING)
      {
        $celldata[self::DATA] = utf8_decode($celldata[self::DATA]);
      }
      $this->sheets[$sheet][$this->getCell($row, $col)] = $celldata;
      return true;
    }
    else {
      return false;
    }
  }

  protected function setSpreadsheetProperties($title = "", $subject = "", $description = "", $creator = "", $modificator = "")
  {
    /*
    $this->spreadsheet->getProperties()->setCreator($creator);
    $this->spreadsheet->getProperties()->setLastModifiedBy($creator);
    $this->spreadsheet->getProperties()->setTitle($title);
    $this->spreadsheet->getProperties()->setSubject($subject);
    $this->spreadsheet->getProperties()->setDescription($description);
    */
  }

  protected function send()
  {
    $this->spreadsheet->sendFile(\StringUtil::sanitizeFileName(htmlspecialchars_decode($this->filename)).'.xls');
    exit;
  }

  protected function setCellSpreadsheet($sheet, $cell)
  {
    $pos = $this->getCell($cell[self::ROW]+1, $cell[self::COL]);
    $found = false;
    foreach ($this->spreadsheet->worksheets as $sheetarray)
    {
      if ($sheetarray['sheetname'] === utf8_decode($sheet)) $found = true;
    }

    if (!$found)
    {
      $this->spreadsheet->addworksheet(utf8_decode($sheet));
    }
    $data = [
      "sheetname" => utf8_decode($sheet),
      "row" => $cell[self::ROW],
      "col" => $cell[self::COL],
      "data" => $cell[self::DATA]
    ];
    $this->spreadsheet->setcell($data);

    switch ($cell[self::CELLTYPE])
    {
      case CELLTYPE_STRING:
        $data['type'] = CELL_STRING;
        break;
      case CELLTYPE_FLOAT:
        $data['type'] = CELL_FLOAT;
        break;
      case CELLTYPE_PICTURE:
        $data['type'] = CELL_PICTURE;
        break;
      case CELLTYPE_INTEGER:
      default:
        break;
    }

    if (array_key_exists(self::BGCOLOR, $cell))
    {
      $data['bgcolor'] = $cell[self::BGCOLOR];
    }
    if (array_key_exists(self::COLOR, $cell))
    {
      $data['color'] = $cell[self::COLOR];
    }

    if (array_key_exists(self::ALIGNMENT, $cell))
    {
      switch ($cell[self::ALIGNMENT])
      {
        case self::ALIGNMENT_H_GENERAL:
            $data['hallign'] = XLSXF_HALLIGN_GENERAL;
            break;
          case self::ALIGNMENT_H_LEFT:
            $data['hallign'] = XLSXF_HALLIGN_LEFT;
            break;
          case self::ALIGNMENT_H_CENTER:
            $data['hallign'] = XLSXF_HALLIGN_CENTER;
            break;
          case self::ALIGNMENT_H_RIGHT:
            $data['hallign'] = XLSXF_HALLIGN_RIGHT;
            break;
          case self::ALIGNMENT_H_FILL:
            $data['hallign'] = XLSXF_HALLIGN_FILL;
            break;
          case self::ALIGNMENT_H_JUSTIFY:
            $data['hallign'] = XLSXF_HALLIGN_JUSTIFY;
            break;
          case self::ALIGNMENT_H_CENTER_CONT:
            $data['hallign'] = XLSXF_HALLIGN_CACROSS;
            break;
      }
    }

    if (array_key_exists(self::FONTWEIGHT, $cell))
    {
      switch ($cell[self::FONTWEIGHT])
      {
        case self::FONTWEIGHT_BOLD:
          $data['fontweight'] = XLSFONT_BOLD;
          break;
      }
    }

    if (array_key_exists(self::FONTSTYLE, $cell))
    {
      switch ($cell[self::FONTSTYLE])
      {
        case self::FONTSTYLE_ITALIC:
          $data['fontstyle'] = XLSFONT_STYLE_ITALIC;
          break;
      }
    }

    $this->spreadsheet->setcell($data);
  }

}
