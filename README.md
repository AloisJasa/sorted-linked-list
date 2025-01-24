# SortedLinkedList
## Immutable sorted linked list

```php

$list = SortedLinkedList::createFromArray("Cucumber", "Apple", "Banana", "Lemon","Carrot");
$list = $list->insert("Avocado");
$list = $list->remove("Banana");

if ($list->contains("Banana")) {
    do_something();
}
```
