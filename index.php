<?php
class Flyweight
{
    private $sharedState;

    public function __construct($sharedState)
    {
        $this->sharedState = $sharedState;
    }

    public function operation($uniqueState): void
    {
        $s = json_encode($this->sharedState);
        $u = json_encode($uniqueState);
        echo "Flyweight: Menampilkan ($s) and unique ($u).\n<br>";
    }
}

class FlyweightFactory
{

    private $flyweights = [];

    public function __construct(array $initialFlyweights)
    {
        foreach ($initialFlyweights as $state) {
            $this->flyweights[$this->getKey($state)] = new Flyweight($state);
        }
    }


    private function getKey(array $state): string
    {
        ksort($state);

        return implode("_", $state);
    }


    public function getFlyweight(array $sharedState): Flyweight
    {
        $key = $this->getKey($sharedState);

        if (!isset($this->flyweights[$key])) {
            echo "FlyweightFactory: Tidak dapat menemukan flyweight, membuat yang baru.\n<br>";
            $this->flyweights[$key] = new Flyweight($sharedState);
        } else {
            echo "FlyweightFactory: Memakai kembali flyweight yang sudah ada.\n<br>";
        }

        return $this->flyweights[$key];
    }

    public function listFlyweights(): void
    {
        $count = count($this->flyweights);
        echo "\nFlyweightFactory: Terdapat $count flyweights:\n<br>";
        foreach ($this->flyweights as $key => $flyweight) {
            echo $key . "\n";
        }
    }
}


$factory = new FlyweightFactory([
    ["Beras","20kg<br>"],
    ["Kunyit", "2kg<br>"],
    ["Terigu", "2kg<br>"],
    ["Tomat", "5kg"],
	
    // ...
]);
$factory->listFlyweights();



function menambahbahan(
    FlyweightFactory $ff, $bahan, $jumlah
) {
    echo "\n<br>Client: Menambahkan bahan baku ke database.\n<br>";
    $flyweight = $ff->getFlyweight([$bahan, $jumlah]);
	$flyweight->operation([$bahan, $jumlah]);
}

menambahbahan($factory,
    "Beras",
    "20kg"
);

menambahbahan($factory,
    "Minyak",
    "20Liter"

);

$factory->listFlyweights();