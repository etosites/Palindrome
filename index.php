<?php 
class StringPalindromeTester
{
	public $processedString;
	private $revString;
	
	public function __construct(STRING $string)
	{
		$this->processedString  = mb_strtolower(preg_replace('/\s+/', '', $string));//пробелы нам не нужны, как и заглавные буквы
		$this->revString = self::mb_strrev($this->processedString);//реверс строки для UTF-8
	}
	
	
	public function isPalindrome()
	{
		return (mb_strlen($this->processedString) <2 || $this->revString == $this->processedString);//если один или ноль знаков или срабатывает реверс, то по-любому палиндром
	}
	
	
	static function mb_strrev($str){
		$r = '';
		for ($i = mb_strlen($str); $i >= 0; $i--) {
			$r .= mb_substr($str, $i, 1);
		}
		return $r;
	}
	
	public function __toString()
	{
	  return $this->processedString;
	}

}

class PalindromeFinder
{
	public $str;
	private $longPalindrome;
	private $strlen;
	
	public function __construct(StringPalindromeTester $string)
	{
		$this->str=$string;
		$this->strlen = mb_strlen($this->str);
		$this->longPalindrome=mb_substr($this->str, 0, 1);
		$this->everyoneAscenter();
	}
	
	public function getLongPalindrome()
	{

		return $this->longPalindrome;
	}
	
	private function everyoneAscenter()//будем искать учитывая, что у подпалиндромов есть центр 
	{
		for ($c = 1; $c <= $this->strlen-1; $c++) {
			$this->LeftRightCaretaker($c);
		}
	}
	
	private function LeftRightCaretaker($center)//получаем центр строки и дальше смотрим
	{	
		$icount = min($this->strlen - $center , $center);
			for ($i = 1; $i <= $icount; $i++) {//идем от центра добавляя по символу в одну итерацию
			$this->isLongerPalindrome(mb_substr($this->str, $center-$i, $i*2));
			$this->isLongerPalindrome(mb_substr($this->str, $center-$i, $i*2+1));
		}		
	}
	
	private function isLongerPalindrome($str)
	{
		
		$mayBePalindrome = new StringPalindromeTester($str);
		if(mb_strlen($this->longPalindrome)<=mb_strlen($str)&&$mayBePalindrome->isPalindrome()){
			$this->longPalindrome = $str;
			}
	}

	
}


$string = 'Аргентина манит негра';
$testPalindrome = new StringPalindromeTester($string);

if($testPalindrome->isPalindrome()){
	echo $string;}
else{
	$subPolignome = new PalindromeFinder($testPalindrome);
	echo $subPolignome-> getLongPalindrome();

}

