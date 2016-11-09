<?php return [
    'plugin'     => [
        'name'                 => 'Snipcart Shop',
        'description'          => 'Ecommerce plugin using the Snipcart backend for October CMS',
        'titles'               => [
            'products'   => [
                'create'  => 'Produkt erstellen',
                'update'  => 'Produkt bearbeiten',
                'preview' => 'Produkt-Vorschau',
            ],
            'categories' => [
                'create'  => 'Kategorie erstellen',
                'update'  => 'Kategorie bearbeiten',
                'preview' => 'Kategorie-Vorschau',
            ],
        ],
        'menu_items'           => [
            'all_categories' => 'Alle Shop-Kategorien',
        ],
        'settings'             => [
            'category'                  => 'Shop',
            'label'                     => 'Snipcart-Shop konfigurieren',
            'description'               => 'Konfigurieren Sie Ihren Shop',
            'sections'                  => [
                'currencies'         => 'Währungen',
                'currencies_comment' => 'Welche Währungen werden in Ihrem Shop verwendet?',
                'checkout'           => 'Checkout',
                'checkout_comment'   => 'Einstellungen zum Checkout',
            ],
            'currencies'                => 'Geben Sie jeweils nur den offiziellen dreistelligen Währungscode ein.',
            'currency_code'             => 'Währungscode',
            'product_page'              => 'Produkt-Seite mit Checkout-Button',
            'product_page_comment'      => 'Auf dieser Seite muss der Checkout-Button von Snipcart vorhanden sein.',
            'product_page_slug'         => 'URL-Parameter (Standard: "slug")',
            'product_page_slug_comment' => 'Verwende diesen Parameter aus der URL um das Produkt zu finden.',
            'auto_pop'                  => 'Warenkorb nach Hinzufügen anzeigen',
            'auto_pop_comment'          => 'Der Warenkorb wird direkt angezeigt, wenn ein Produkt hinzugefügt wurde',
            'api_key'                   => 'API-Key',
            'api_key_comment'           => 'API-Key von snipcart.com',
        ],
        'common'               => [
            'shop'               => 'Shop',
            'products'           => 'Produkte',
            'cart'               => 'Warenkorb',
            'shipping'           => 'Versand',
            'taxes'              => 'Steuern',
            'inventory'          => 'Lagerbestand',
            'custom_fields'      => 'Benutzerdefinierte Felder',
            'variants'           => 'Varianten',
            'select_placeholder' => '-- Bitte wählen',
            'main_image'         => 'Hauptbild',
            'images'             => 'Bilder',
            'select_image'       => 'Bild auswählen',
            'allowed'            => 'Erlaubt',
            'not_allowed'        => 'Nicht erlaubt',
            'seo'                => 'SEO',
            'categories'         => 'Kategorien',
            'meta_title'         => 'Meta-Titel',
            'meta_description'   => 'Meta-Beschreibung',
            'reorder'            => 'Reihenfolge ändern',
            'id'                 => 'ID',
            'created_at'         => 'Erstellungsdatum',
            'slug'               => 'URL',
        ],
        'variant'              => [
            'method' => [
                'single'  => 'Artikel',
                'variant' => 'Artikelvarianten',
            ],
        ],
        'custom_field_options' => [
            'text'       => 'Textfeld',
            'textarea'   => 'Mehrzeiliges Textfeld',
            'dropdown'   => 'Auswahlliste',
            'checkbox'   => 'Checkbox',
            'add'        => 'Option hinzufügen',
            'name'       => 'Name',
            'price'      => 'Aufpreis',
            'attributes' => 'Attribute',
            'option'     => 'Option',
        ],
        'product'              => [
            'user_defined_id'                      => 'Artikelnummer',
            'name'                                 => 'Produktname',
            'published'                            => 'Veröffentlicht',
            'not_published'                        => 'Nicht veröffentlicht',
            'published_comment'                    => 'Dieser Artikel ist im Shop sichtbar',
            'stock'                                => 'Lagerbestand',
            'price'                                => 'Preis',
            'description_short'                    => 'Kurzbeschreibung',
            'description'                          => 'Beschreibung',
            'weight'                               => 'Gewicht (g)',
            'length'                               => 'Länge (mm)',
            'height'                               => 'Höhe (mm)',
            'width'                                => 'Breite (mm)',
            'quantity_default'                     => 'Standard-Bestellmenge',
            'quantity_min'                         => 'Minimale Bestellmenge',
            'quantity_max'                         => 'Maximale Bestellmenge',
            'inventory_management_method'          => 'Inventarverwaltungs-Methode',
            'allow_out_of_stock_purchases'         => 'Nicht-an-Lager-Kauf erlauben',
            'allow_out_of_stock_purchases_comment' => 'Dieser Artikel darf auch dann bestellt werden, wenn er nicht an Lager ist',
            'stackable'                            => 'In Warenkorb zusammenfassen',
            'stackable_comment'                    => 'Beim mehrmaligen Hinzufügen zum Warenkorb diesen Artikel nur einmal auflisten (Anzahl erhöhen)',
            'shippable'                            => 'Versand möglich',
            'shippable_comment'                    => 'Dieser Artikel kann versendet werden',
            'taxable'                              => 'Besteuert',
            'taxable_comment'                      => 'Auf diesen Artikel fallen Steuern an',
            'add_currency'                         => 'Währung hinzufügen',
            'currency'                             => 'Währung',
        ],
        'category'             => [
            'name'      => 'Name',
            'parent'    => 'Elternelement',
            'no_parent' => 'Kein Elternelement',
        ],
        'custom_fields'        => [
            'name'             => 'Feldname',
            'type'             => 'Typ',
            'options'          => 'Optionen',
            'required'         => 'Pflichtfeld',
            'required_comment' => 'Dieses Feld muss beim Tätigen einer Bestellung ausgefüllt werden',
            'is_required'      => 'Pflichtfeld',
            'is_not_required'  => 'Kein Pflichtfeld',
        ],
    ],
    'components' => [
        'dependencies' => [
            'details' => [
                'name'        => 'Snipcart-Abhängigkeiten',
                'description' => 'Von Snipcart benötigte JS-Dateien',
            ],
            'properties' => [
                'include_jquery' => [
                    'title' => 'jQuery einbinden',
                    'description' => 'Bindet jQuery von code.jquery.com ein'
                ]
            ]
        ],
        'products'     => [
            'details'    => [
                'name'        => 'Produkt-Liste',
                'description' => 'Zeigt eine Liste von Produkten an',
            ],
            'properties' => [
                'categoryFilter'    => [
                    'title'       => 'Kategorie-Filter',
                    'description' => 'Zeige nur Produkte aus dieser Kategorie an.',
                    'no_filter'   => 'Alle Produkte anzeigen',
                    'by_slug'     => 'Kategorie aus URL übernehmen',
                ],
                'categorySlug'      => [
                    'title'       => 'Kategorie URL-Parameter',
                    'description' => 'Verwende diesen Parameter um den Kategorie-Filter aus der URL zu übernehmen',
                ],
                'productsPerPage'   => [
                    'title' => 'Anzahl Produkte pro Seite',
                ],
                'noProductsMessage' => [
                    'title'       => '«Keine Produkte»-Meldung',
                    'description' => 'Dieser Test wird angezeigt, wenn keine Artikel angezeigt werden können.',
                ],
                'sortOrder'         => [
                    'title'       => 'Sortierung',
                    'description' => 'Nach welchem Attribut die Produkte sortiert werden.',
                ],
                'productPage'       => [
                    'title'       => 'Produkt-Seite',
                    'description' => 'Die Links werden auf diese Seite verweisen.',
                ],
            ],
        ],
        'product'      => [
            'details'    => [
                'name'        => 'Produkt-Details',
                'description' => 'Zeigt die Details zu einem Produkt an',
            ],
            'properties' => [
                'productSlug' => [
                    'title'       => 'Produkt URL-Parameter',
                    'description' => 'Verwende diesen Parameter um das Produkt aus der URL zu übernehmen',
                ],
            ],
        ],
    ],
];