<?php
include 'XMLUtils.php';
$doc = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<phplamp id="t1">
    <post id="p1">
        <title id="1">PHP XML处理介绍一</title>
        <details>详细内容一</details>
    </post>
    <post id="p2">
        <title id="2">PHP XML处理介绍二</title>
        <details>详细内容二</details>
    </post>
    <post id="p3">
        <title id="3">PHP XML处理介绍三</title>
        <details>详细内容三</details>
    </post>
</phplamp>
XML;

$iterator = new SimpleXMLIterator($doc);
print_r(XMLUtils::traver($iterator));


/*$xml = simplexml_load_string($doc);
$xml->addChild('post');
$xml->post[3]->addAttribute('id','p4');
$xml->post[3]->addChild('title','PHP XML处理介绍四')->addAttribute('id', '4');
$xml->post[3]->addChild('details','详细内容四');
print_r($xml);
$new = <<<XML
<post id="p4">
    <title id="4" >PHP XML处理介绍四</title>
    <details>详细内容四</details>
</post>
XML;

$node = new SimpleXMLElement($new);
print_r($node);*/


