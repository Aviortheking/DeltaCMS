<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEnum extends TestCase {

	public function testInstantiateEnum(): void {
		$this->expectException(Error::class);
		new Enum();
	}

	public function testValidOption(): void {
		$this->assertEquals(
			0,
			OptionTypes::String
		);
	}

	public function testIsValidName(): void {
		$this->assertEquals(
			true,
			OptionTypes::isValidName("String")
		);
		$this->assertEquals(
			false,
			OptionTypes::isValidName("Sting")
		);
		$this->assertEquals(
			false,
			OptionTypes::isValidName("string", true)
		);
	}
}
