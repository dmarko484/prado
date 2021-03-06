<?php

class TextBoxCallbackTestCase extends PradoGenericSeleniumTest
{
	function test()
	{
		$this->open("active-controls/index.php?page=ActiveTextBoxCallback");
		$this->verifyTextPresent("ActiveTextBox Callback Test");
		$this->assertText("label1", "Label 1");

		$this->type("textbox1", "hello!");
		$this->pause(800);
		$this->assertText("label1", "Label 1: hello!");
	}
}
