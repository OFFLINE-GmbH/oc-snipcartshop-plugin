<?php return [
    'plugin' => [
        'name' => 'Snipcart Shop',
        'description' => 'Ecommerce plugin using the Snipcart backend for October CMS',
        'titles' => [
            'products' => [
                'create' => 'Produkt erstellen',
                'update' => 'Produkt bearbeiten',
                'preview' => 'Produkt-Vorschau',
            ]
        ],
        'common' => [
            'shop' => 'Shop',
            'products' => 'Produkte',
            'cart' => 'Warenkorb',
            'shipping' => 'Versand',
            'taxes' => 'Steuern',
            'inventory' => 'Lagerbestand',
            'custom_fields' => 'Benutzerdefinierte Felder',
            'variants' => 'Varianten',
            'select_placeholder' => '-- Bitte wählen',
        ],
        'variant' => [
            'method' => [
                'single' => 'Artikel',
                'variant' => 'Artikelvarianten',
            ]
        ],
        'custom_field_options' => [
            'text' => 'Textfeld',
            'textarea' => 'Mehrzeiliges Textfeld',
            'dropdown' => 'Auswahlliste',
            'add' => 'Option hinzufügen',
            'name' => 'Name',
            'price' => 'Aufpreis',
            'attributes' => 'Attribute'
        ],
        'product' => [
            'user_defined_id' => 'Artikelnummer',
            'name' => 'Produktname',
            'published' => 'Veröffentlicht',
            'published_comment' => 'Dieser Artikel ist im Shop sichtbar',
            'stock' => 'Lagerbestand',
            'price' => 'Preis',
            'description_short' => 'Kurzbeschreibung',
            'description' => 'Beschreibung',
            'weight' => 'Gewicht (g)',
            'length' => 'Länge (mm)',
            'height' => 'Höhe (mm)',
            'width' => 'Breite (mm)',
            'quantity_default' => 'Standard-Bestellmenge',
            'quantity_min' => 'Minimale Bestellmenge',
            'quantity_max' => 'Maximale Bestellmenge',
            'inventory_management_method' => 'Inventarverwaltungs-Methode',
            'allow_out_of_stock_purchases' => 'Nicht-an-Lager-Kauf erlauben',
            'allow_out_of_stock_purchases_comment' => 'Dieser Artikel darf auch dann bestellt werden, wenn er nicht an Lager ist',
            'stackable' => 'In Warenkorb zusammenfassen',
            'stackable_comment' => 'Beim mehrmaligen Hinzufügen zum Warenkorb diesen Artikel nur einmal auflisten (Anzahl erhöhen)',
            'shippable' => 'Versand möglich',
            'shippable_comment' => 'Dieser Artikel kann versendet werden',
            'taxable' => 'Besteuert',
            'taxable_comment' => 'Auf diesen Artikel fallen Steuern an',
        ],
        'custom_fields' => [
            'name' => 'Feldname',
            'type' => 'Typ',
            'options' => 'Optionen',
            'required' => 'Pflichtfeld',
            'required_comment' => 'Dieses Feld muss beim Tätigen einer Bestellung ausgefüllt werden'
        ],
    ],
];