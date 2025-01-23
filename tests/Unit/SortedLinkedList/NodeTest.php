<?php declare(strict_types = 1);

namespace AloisJasa\SortedLinkedList\Tests\Unit\SortedLinkedList;

use AloisJasa\SortedLinkedList\SortedLinkedList\Node;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
	public function testWithNext(): void
	{
		$node = new Node(10);
		$this->assertNull($node->next);

		$newNode = $node->withNext(new Node(5));
		$this->assertNotSame($newNode, $node);
		$this->assertSame(5, $newNode->next->value);
	}


	public function testInvalidType(): void
	{
		$node = new Node(10);
		$this->expectException(InvalidArgumentException::class);
		$node->withNext(new Node('5'));
	}


	public function testCircularReference(): void
	{
		$node = new Node(10);
		$this->expectException(InvalidArgumentException::class);
		$node->withNext($node);
	}
}
