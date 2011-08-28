<?php
/****************************************************************
* Script         : PHP Simple Excel File Generator - Base Class
* Project        : PHP SimpleXlsGen
* Author         : Erol Ozcan <eozcan@superonline.com>
* Version        : 0.3
* Copyright      : GNU LGPL
* URL            : http://psxlsgen.sourceforge.net
* Last modified  : 13 Jun 2001
* Description     : This class is used to generate very simple
*   MS Excel file (xls) via PHP.
*   The generated xls file can be obtained by web as a stream
*   file or can be written under $default_dir path. This package
*   is also included mysql, pgsql, oci8 database interaction to
*   generate xls files.
*   Limitations:
*    - Max character size of a text(label) cell is 255
*    ( due to MS Excel 5.0 Binary File Format definition )
*
* Credits        : This class is based on Christian Novak's small
*    Excel library functions.
******************************************************************/



   class  PhpSimpleXlsGen {
      var  $class_ver = "0.3";    // class version
      var  $xls_data   = "";      // where generated xls be stored
      var  $default_dir = "";     // default directory to be saved file
      var  $filename  = "psxlsgen";       // save filename
      var  $fname    = "";        // filename with full path
      var  $crow     = 0;         // current row number
      var  $ccol     = 0;         // current column number
      var  $totalcol = 0;         // total number of columns
      var  $get_type = 0;         // 0=stream, 1=file
      var  $errno    = 0;         // 0=no error
      var  $error    = "";        // error string
      var  $dirsep   = "/";       // directory separator
      var  $header   = 1;         // 0=no header, 1=header line for xls table

     // Default constructor
     public function  __construct()
     {
       $os = getenv( "OS" );
       $temp = getenv( "TEMP");
       // check OS and set proper values for some vars.
       if ( stristr( $os, "Windows" ) ) {
          $this->default_dir = $temp;
          $this->dirsep = "\\";
       } else {
         // assume that is Unix/Linux
         $this->default_dir = "/tmp";
         $this->dirsep =  "/";
       }
       // begin of the excel file header
       $this->xls_data = pack( "ssssss", 0x809, 0x08, 0x00,0x10, 0x0, 0x0 );
       // check header text
       if ( $this->header ) {
         $this->Header();
       }
     }

     public function Header( $text="" ) {
        if ( $text == "" ) {
           $text = "This file was generated using PSXlsGen at ".date("D, d M Y H:i:s T");
        }
        if ( $this->totalcol < 1 ) {
          $this->totalcol = 1;
        }
        $this->InsertText( $text );
        $this->crow += 2;
        $this->ccol = 0;
     }

     // end of the excel file
     public function End()
     {
       $this->xls_data .= pack("sssssssC", 0x7D, 11, 3, 4, 25600,0,0,0);
       $this->xls_data .= pack( "ss", 0x0A, 0x00 );
       return;
     }

     // write a Number (double) into row, col
     public function WriteNumber_pos( $row, $col, $value )
     {
        $this->xls_data .= pack( "d", $value );
        return;
     }

     // write a label (text) into Row, Col
     public function WriteText_pos( $row, $col, $value )
     {
        $len = strlen( $value );
        $this->xls_data .= $value;
        return;
     }

     // insert a number, increment row,col automatically
     public function InsertNumber( $value )
     {
        if ( $this->ccol == $this->totalcol ) {
           $this->ccol = 0;
           $this->crow++;
        }
        $this->WriteNumber_pos( $this->crow, $this->ccol, &$value );
        $this->ccol++;
        return;
     }

     // insert a number, increment row,col automatically
     public function InsertText( $value )
     {
        if ( $this->ccol == $this->totalcol ) {
           $this->ccol = 0;
           $this->crow++;
        }
        $this->WriteText_pos( $this->crow, $this->ccol, &$value );
        $this->ccol++;
        return;
     }

     // Change position of row,col
     public function ChangePos( $newrow, $newcol )
     {
        $this->crow = $newrow;
        $this->ccol = $newcol;
        return;
     }

     // new line
     public function NewLine()
     {
        $this->ccol = 0;
        $this->crow++;
        return;
     }

     // send generated xls as stream file
    /* function SendFile( $filename )
     {
        $this->filename = $filename;
        $this->SendFile();
     }
	 */
     // send generated xls as stream file
     public function SendFile()
     {
        $this->End();
        header ( "Expires: 0" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/x-msexcel" );
        header ( "Content-Disposition: attachment; filename=$this->filename.xls" );
        header ( "Content-Description: PHP Generated XLS Data" );
        echo $this->xls_data;
     }

     // change the default saving directory
     public function ChangeDefaultDir( $newdir )
     {
       $this->default_dir = $newdir;
       return;
     }

     // Save generated xls file
     /*function SaveFile( $filename )
     {
        $this->filename = $filename;
        $this->SaveFile();
     }
	 */

     // Save generated xls file
     public function SaveFile()
     {
        $this->End();
        $this->fname = $this->default_dir."$this->dirsep".$this->filename;
        if ( !stristr( $this->fname, ".xls" ) ) {
          $this->fname .= ".xls";
        }
        $fp = fopen( $this->fname, "wb" );
        fwrite( $fp, $this->xls_data );
        fclose( $fp );
        return;
     }

     // Get generated xls as specified type
     public function GetXls( $type = 0 ) {
         if ( !$type && !$this->get_type ) {
            $this->SendFile();
         } else {
            $this->SaveFile();
         }
     }
   } // end of the class PHP_SIMPLE_XLS_GEN
// end of ifdef PHP_SIMPLE_XLS_GEN