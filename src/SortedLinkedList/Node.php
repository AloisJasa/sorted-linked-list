<?php declare(strict_types = 1);

namespace AloisJasa\SortedLinkedList\SortedLinkedList;

use InvalidArgumentException;

readonly class Node
{
	public function __construct(
		public int|string $value,
		public ?Node $next = null,
	)
	{
	}


	public function withNext(?Node $next): Node
	{
		if ($next === $this->next) {
			return $this;
		}
		if ($next === $this) {
			throw new InvalidArgumentException('Circular reference is not allowed');
		}
		if ($next !== null && gettype($this->value) !== gettype($next->value)) {
			throw new InvalidArgumentException(sprintf('Elements must be of same type %s', gettype($this->value)));
		}

		return new Node($this->value, $next);
	}
}
