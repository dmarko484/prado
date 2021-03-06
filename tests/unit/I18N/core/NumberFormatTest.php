<?php


//NOTE: This page require UTF-8 aware editors
Prado::using('System.I18N.core.NumberFormat');

/**
 * @package System.I18N.core
 */
class NumberFormatTest extends PHPUnit_Framework_TestCase {
  function testDefaultFormats() {
    $formatter = new NumberFormat();
    $number = '123456789.125156';
    $wanted = '123,456,789.125156';

    $this->assertEquals($wanted, $formatter->format($number));
    
    //currency
    $wanted = 'US$123,456,789.13';
    $this->assertEquals($wanted, $formatter->format($number,'c'));
  }

  function testLocalizedCurrencyFormats() {
    $fr = new NumberFormat('fr');
    $de = new NumberFormat('de');
    $ja = new NumberFormat('ja_JP');
    $it = new NumberFormat('it_IT');
    
    $number = '123456789.125156';
    
    //french
    $wanted = '123 456 789,13 F';
    $this->assertEquals($wanted, $fr->format($number,'c','FRF'));
    
    //german
    $wanted = 'DES 123.456.789,13';
    $this->assertEquals($wanted, $de->format($number,'c','DES'));
    
    //japanese
    $wanted = '￥123,456,789';
    $this->assertEquals($wanted, $ja->format($number,'c','JPY'));
    
    //custom/unkown currency
    $wanted = 'DLL123,456,789';
    $this->assertEquals($wanted, $ja->format($number,'c','DLL'));

    //italian
    $wanted = '€ 123.456.789,13';
    $this->assertEquals($wanted, $it->format($number,'c','EUR'));
  }

  function testCustomFormat() {
    $formatter = new NumberFormat();
    $number = '123456789.125156';
    
    //primay and secondary grouping test
    $pattern = '#,###,##.###';
    $wanted = '1,234,567,89.125156';
    $this->assertEquals($wanted, $formatter->format($number, $pattern));
    
    //4 digits grouping test
    $pattern = '#,####.###';
    $wanted = '1,2345,6789.125156';
    $this->assertEquals($wanted, $formatter->format($number, $pattern));
    
    //custom percentage
    $pattern = '#,###.00%';
    $wanted = '123,456,789.13%';
    $this->assertEquals($wanted, $formatter->format($number, $pattern));
  }
  
  function testPercentageFormat() {
    $formatter = new NumberFormat();
    $number = '0.125156';
    $wanted = '12%';
    $this->assertEquals($wanted, $formatter->format($number, 'p'));
  }
  
  function testQuotes() {
    $formatter = new NumberFormat();
    $number = '123456789.125156';
    
    $pattern = "# o'clock";
    $wanted = "123456789 o'clock";
    $this->assertEquals($wanted, $formatter->format($number, $pattern));
    
  }
  
  function testPadding() {
    $formatter = new NumberFormat();
    $number = '5';
    
    $pattern = '0000';
    $wanted = '0005';
    
    $this->assertEquals($wanted, $formatter->format($number, $pattern));
  }
  
  function testFormatWithANegativeValue() {
    $formatter = new NumberFormat();
    $number = "-1.2";
    
    $wanted = "-1.2";
    $this->assertEquals($wanted, $formatter->format($number));
  }

  public function testFormatWithAScientificPattern() {
    $formatter = new NumberFormat();
    $number = "10";
    $expected = "10E";
    $this->assertEquals('10E', $formatter->format($number, 'e'));
  }
  
  function testRounding()
  {
      $formatter = new NumberFormat();
      
      $number = 349.999;
      $pattern = '#.00';
      $expected = '350.00';
      
      $this->assertEquals($expected, $formatter->format($number, $pattern));
  }

  function testRounding2()
  {
      $formatter = new NumberFormat();
      
      $number = 349.99;
      $pattern = '#.00';
      $expected = '349.99';
      
      $this->assertEquals($expected, $formatter->format($number, $pattern));
  }

  function testLocalizedCurrencyFormats2() {

    $it = new NumberFormat('it_IT');
  
    $number = 12.41;
    $wanted = '12,41';
    $this->assertEquals($wanted, $it->format($number,'d'));

    $number = 10.23;
    $wanted = '10,23';
    $this->assertEquals($wanted, $it->format($number,'d'));

    $number = 10010.23;
    $wanted = '10.010,23';
    $this->assertEquals($wanted, $it->format($number,'d'));

    $old= setlocale(LC_ALL,"0"); 
    setlocale(LC_ALL,"it_IT");

    $number = 12.41;
    $wanted = '12,41';
    $this->assertEquals($wanted, $it->format($number,'d'));

    $number = 10.23;
    $wanted = '10,23';
    $this->assertEquals($wanted, $it->format($number,'d'));

    $number = 10010.23;
    $wanted = '10.010,23';
    $this->assertEquals($wanted, $it->format($number,'d'));

    setlocale(LC_ALL,$old);
  }
}

?>