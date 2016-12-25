<?php

namespace Rylai\Stores;

use Elasticsearch\ClientBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Elasticsearch implements StoreInterface
{
    protected $_options;

    protected $_client;

    const TYPE = "file";

    public function __construct($options)
    {
        $resolver = new OptionsResolver;
        $resolver->setRequired(["hosts", "index"]);
        $resolver->setAllowedTypes("hosts", "array");

        $this->_options = $resolver->resolve($options);
        $this->_client  = ClientBuilder::create()
            ->setHosts($this->_options["hosts"])
            ->build();

        $index = [
            "index" => $this->_options["index"],
        ];
        if (!$this->_client->indices()->exists($index)) {
            $this->_client->indices()->create([
                "index" => $this->_options["index"],
            ]);
        }
    }

    public function store(\stdClass $report)
    {
        $response = $this->_client->index([
            "index" => $this->_options["index"],
            "type"  => self::TYPE,
            "id"    => md5($report->file),
            "body"  => [
                "doc" => $report,
            ],
        ]);
        if (!$response) {
            throw new \Exception(json_encode($response));
        }
    }
}
