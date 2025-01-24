<?php declare(strict_types = 1);

namespace AloisJasa\SortedLinkedList\SortedLinkedList;

use InvalidArgumentException;

readonly class SortedLinkedList
{
	private ?string $type;


	public function __construct(
		public ?Node $head = null,
	)
	{
		$this->type = $head !== null ? gettype($head->value) : null;
	}


	public function insert(int|string $value): SortedLinkedList
	{
		if ($this->type !== null && gettype($value) !== $this->type) {
			throw new InvalidArgumentException(sprintf('All elements must be of type %s', $this->type));
		}
		if ($this->head === null) {
			return new SortedLinkedList(new Node($value));
		}

		return new SortedLinkedList($this->findNext($value, $this->head));
	}


	public function remove(int|string $value): SortedLinkedList
	{
		if ($this->type !== null && gettype($value) !== $this->type) {
			return $this;
		}
		if ($this->head === null) {
			return $this;
		}

		$newHead = $this->findNextWithoutProhibitedValue($value, $this->head);
		if ($newHead === $this->head) {
			return $this;
		}

		return new SortedLinkedList($newHead);
	}


	public function contains(int|string $value): bool
	{
		if ($this->type !== null && gettype($value) !== $this->type) {
			return false;
		}

		$current = $this->head;
		while ($current !== null) {
			if ($current->value === $value) {
				return true;
			}
			$current = $current->next;
		}

		return false;
	}


	private function findNextWithoutProhibitedValue(int|string $value, ?Node $node): ?Node
	{
		if ($node === null) {
			return null;
		}

		if ($node->value === $value) {
			return $node->next;
		}

		return $node->withNext($this->findNextWithoutProhibitedValue($value, $node->next));
	}


	private function findNext(int|string $value, ?Node $node): Node
	{
		if ($node === null) {
			return new Node($value, null);
		}

		if (self::compare($node->value, $value) < 0) {
			return $node->withNext($this->findNext($value, $node->next));
		}

		return new Node($value, $node);
	}


	/**
	 * @return list<int|string>
	 */
	public function toArray(): array
	{
		$result = [];
		$current = $this->head;
		while ($current !== null) {
			$result[] = $current->value;
			$current = $current->next;
		}

		return $result;
	}


	public static function createFromArray(int|string ...$values): self
	{
		usort($values, static fn (int|string $a, int|string $b) => self::compare($b, $a));
		$node = null;
		foreach ($values as $value) {
			$node = new Node($value, $node ?? null);
		}

		return new self($node);
	}


	private static function compare(int|string $a, int|string $b): int
	{
		if (is_int($a) && is_int($b)) {
			return $a <=> $b;
		}

		if (is_string($a) && is_string($b)) {
			return $a <=> $b;
		}

		return is_int($a) ? -1 : 1;
	}
}
