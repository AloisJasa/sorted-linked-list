<?php declare(strict_types = 1);

namespace AloisJasa\SortedLinkedList\Tests\Unit\SortedLinkedList;

use AloisJasa\SortedLinkedList\SortedLinkedList\SortedLinkedList;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SortedLinkedListTest extends TestCase
{
	public static function provideInsertData(): array
	{
		return [
			[
				[5, 6, 3, 1, 10],
				[1, 3, 5, 6, 10],
			],
			[
				[5, -6, -3, 1, 10],
				[-6, -3, 1, 5, 10],
			],
			[
				[1, 2, 3, 4, 5],
				[1, 2, 3, 4, 5],
			],
			[
				[5, 4, 3, 2, 1],
				[1, 2, 3, 4, 5],
			],
			[
				["Cucumber", "Apple", "Banana", "Lemon","Carrot"],
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
			],
			[
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
			],
			[
				["Lemon", "Cucumber", "Carrot", "Banana", "Apple"],
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
			],
		];
	}


	#[DataProvider('provideInsertData')]
	public function testInsert(array $input, array $expectation): void
	{
		$list = new SortedLinkedList(null);
		foreach ($input as $value) {
			$list = $list->insert($value);
		}

		$this->assertEquals($expectation, $list->toArray());
	}


	public static function provideRemoveData()
	{
		return [
			[
				[5, 6, 3, 1, 10],
				[1, 3, 5, 6, 10],
			],
			[
				[5, -6, -3, 1, 10],
				[-6, -3, 1, 5, 10],
			],
			[
				[1, 2, 3, 4, 5],
				[1, 2, 3, 4, 5],
			],
			[
				[5, 4, 3, 2, 1],
				[1, 2, 3, 4, 5],
			],
			[
				["Cucumber", "Apple", "Banana", "Lemon","Carrot"],
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
			],
			[
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
			],
			[
				["Lemon", "Cucumber", "Carrot", "Banana", "Apple"],
				["Apple", "Banana", "Carrot", "Cucumber", "Lemon"],
			],
		];
	}


	public function testRemoveNode(): void
	{
		$list = SortedLinkedList::createFromArray("Cucumber", "Apple", "Banana", "Lemon","Carrot");
		$list = $list->remove("Banana");
		$this->assertEquals(["Apple", "Carrot", "Cucumber", "Lemon"], $list->toArray());
		$list = $list->remove("NotIn");
		$this->assertEquals(["Apple", "Carrot", "Cucumber", "Lemon"], $list->toArray());
		$list =  $list->remove(5);
		$this->assertEquals(["Apple", "Carrot", "Cucumber", "Lemon"],$list->toArray());
		$list = $list->remove("Lemon");
		$this->assertEquals(["Apple", "Carrot", "Cucumber"], $list->toArray());
		$list = $list->remove("Apple");
		$this->assertEquals(["Carrot", "Cucumber"], $list->toArray());
		$list = $list->remove("Apple");
		$this->assertEquals(["Carrot", "Cucumber"], $list->toArray());
		$list = $list->remove("Cucumber");
		$this->assertEquals(["Carrot"], $list->toArray());
		$list = $list->remove("Carrot");
		$this->assertEquals([], $list->toArray());
	}


	#[DataProvider('provideInsertData')]
	public function testCreateFromArray(array $input, array $expectation): void
	{
		$list = SortedLinkedList::createFromArray(...$input);
		$this->assertEquals($expectation, $list->toArray());
	}


	public static function provideInvalidTypeData(): array
	{
		return [
			[[5, '6']],
			[['1', 2]],
		];
	}


	#[DataProvider('provideInvalidTypeData')]
	public function testInvalidType(array $input): void
	{
		$list = new SortedLinkedList(null);
		$this->expectException(InvalidArgumentException::class);
		foreach ($input as $value) {
			$list = $list->insert($value);
		}
	}


	public function testContains(): void
	{
		$list = SortedLinkedList::createFromArray(5, 4, 3, 2, 1);
		$this->assertTrue($list->contains(5));
		$this->assertTrue($list->contains(4));
		$this->assertTrue($list->contains(3));
		$this->assertTrue($list->contains(2));
		$this->assertTrue($list->contains(1));

		$this->assertFalse($list->contains(15));
		$this->assertFalse($list->contains(24));
		$this->assertFalse($list->contains(33));
		$this->assertFalse($list->contains(0));
		$this->assertFalse($list->contains('5'));
	}
}
