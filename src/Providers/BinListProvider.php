<?php
namespace Commission\Providers;

class BinListProvider implements BinProviderInterface {
    private $euCountries = ['AT','BE','BG','CY','CZ','DE','DK','EE','ES','FI','FR','GR','HR','HU','IE','IT','LT','LU','LV','MT','NL','PO','PT','RO','SE','SI','SK'];

    public function isEu(string $bin): bool {
        $data = json_decode(file_get_contents('https://lookup.binlist.net/' . $bin));
        return in_array($data->country->alpha2, $this->euCountries);
    }
}