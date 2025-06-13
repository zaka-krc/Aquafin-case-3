<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Category;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            // Bevestigingsmateriaal
            'Bevestigingsmateriaal' => [
                ['name' => 'Bouten M6 inox A2', 'unit' => 'stuk', 'description' => 'RVS bout zeskant'],
                ['name' => 'Bouten M8 inox A2', 'unit' => 'stuk', 'description' => 'RVS bout zeskant'],
                ['name' => 'Bouten M10 inox A2', 'unit' => 'stuk', 'description' => 'RVS bout zeskant'],
                ['name' => 'Bouten M12 inox A2', 'unit' => 'stuk', 'description' => 'RVS bout zeskant'],
                ['name' => 'Bouten M16 inox A2', 'unit' => 'stuk', 'description' => 'RVS bout zeskant'],
                ['name' => 'Bouten M6 verzinkt', 'unit' => 'stuk', 'description' => 'Verzinkte bout zeskant'],
                ['name' => 'Moeren zeskant M6', 'unit' => 'stuk', 'description' => 'Standaard zeskantmoer'],
                ['name' => 'Moeren zeskant M8', 'unit' => 'stuk', 'description' => 'Standaard zeskantmoer'],
                ['name' => 'Moeren zeskant M10', 'unit' => 'stuk', 'description' => 'Standaard zeskantmoer'],
                ['name' => 'Borgmoeren M8', 'unit' => 'stuk', 'description' => 'Met nylon ring'],
                ['name' => 'Flensmoeren M10', 'unit' => 'stuk', 'description' => 'Met geïntegreerde ring'],
                ['name' => 'Sluitringen M6', 'unit' => 'stuk', 'description' => 'Platte ring'],
                ['name' => 'Veerringen M8', 'unit' => 'stuk', 'description' => 'Split ring'],
                ['name' => 'Tandringen M10', 'unit' => 'stuk', 'description' => 'Getande borgring'],
                ['name' => 'Ankerbouten M12x110', 'unit' => 'stuk', 'description' => 'Mechanisch anker'],
                ['name' => 'Chemische ankers Hilti HIT', 'unit' => 'patroon', 'description' => '330ml patroon'],
                ['name' => 'Keilbouten M10x100', 'unit' => 'stuk', 'description' => 'Doorsteekanker'],
                ['name' => 'Draadstangen M8', 'unit' => 'meter', 'description' => '1 meter lengte'],
                ['name' => 'Draadstangen M10', 'unit' => 'meter', 'description' => '1 meter lengte'],
                ['name' => 'Draadstangen M12', 'unit' => 'meter', 'description' => '1 meter lengte'],
                ['name' => 'Inslagmoeren M8', 'unit' => 'stuk', 'description' => 'Voor holle wanden'],
                ['name' => 'Tapbouten M6x20', 'unit' => 'stuk', 'description' => 'Zelftappend'],
                ['name' => 'Inbusbouten M6x25', 'unit' => 'stuk', 'description' => 'Cilinderkop'],
                ['name' => 'Torx schroeven T25', 'unit' => 'stuk', 'description' => '4x40mm'],
                ['name' => 'Kruiskopschroeven 4x30', 'unit' => 'stuk', 'description' => 'PZ2'],
                ['name' => 'Zelftappende vijzen 4.2x19', 'unit' => 'stuk', 'description' => 'Voor metaal'],
                ['name' => 'Parkervijzen 3.5x16', 'unit' => 'stuk', 'description' => 'Voor dunne plaat'],
                ['name' => 'Spaanplaatschroeven 5x50', 'unit' => 'stuk', 'description' => 'Verzonken kop'],
                ['name' => 'Slangenklemmen 20-32mm', 'unit' => 'stuk', 'description' => 'RVS wormschroef'],
                ['name' => 'Slangenklemmen 32-50mm', 'unit' => 'stuk', 'description' => 'RVS wormschroef'],
                ['name' => 'Slangenklemmen 50-70mm', 'unit' => 'stuk', 'description' => 'RVS wormschroef'],
            ],
            
            // Persoonlijke beschermingsmiddelen
            'Persoonlijke beschermingsmiddelen (PBM)' => [
                ['name' => 'Veiligheidshelm wit', 'unit' => 'stuk', 'description' => 'Met kinband EN397'],
                ['name' => 'Oordoppen', 'unit' => 'paar', 'description' => 'SNR 37dB'],
                ['name' => 'Gehoorkappen', 'unit' => 'stuk', 'description' => 'SNR 32dB opvouwbaar'],
                ['name' => 'Veiligheidsbril helder', 'unit' => 'stuk', 'description' => 'EN166 krasvrij'],
                ['name' => 'Gelaatsscherm', 'unit' => 'stuk', 'description' => 'Opklapbaar vizier'],
                ['name' => 'Stofmasker FFP2', 'unit' => 'stuk', 'description' => 'Met ventiel'],
                ['name' => 'Stofmasker FFP3', 'unit' => 'stuk', 'description' => 'Voor fijn stof'],
                ['name' => 'Werkhandschoenen snijvast', 'unit' => 'paar', 'description' => 'Niveau 5 bescherming'],
                ['name' => 'Werkhandschoenen chemisch', 'unit' => 'paar', 'description' => 'Nitril gecoat'],
                ['name' => 'Werkhandschoenen elektrisch', 'unit' => 'paar', 'description' => 'Klasse 0 - 1000V'],
                ['name' => 'Veiligheidsschoenen S3', 'unit' => 'paar', 'description' => 'Hoog model antistatisch'],
                ['name' => 'Veiligheidsschoenen S3 laag', 'unit' => 'paar', 'description' => 'Met stalen neus'],
                ['name' => 'Werklaarzen PVC', 'unit' => 'paar', 'description' => 'Met stalen zool S5'],
                ['name' => 'Werklaarzen nitril', 'unit' => 'paar', 'description' => 'Chemisch resistent'],
                ['name' => 'Regenjas fluo', 'unit' => 'stuk', 'description' => 'EN ISO 20471 klasse 3'],
                ['name' => 'Regenbroek fluo', 'unit' => 'stuk', 'description' => 'EN ISO 20471'],
                ['name' => 'Fluovest', 'unit' => 'stuk', 'description' => 'EN ISO 20471 klasse 2'],
                ['name' => 'Overall brandvertragend', 'unit' => 'stuk', 'description' => 'Antistatisch'],
                ['name' => 'Overall waterafstotend', 'unit' => 'stuk', 'description' => 'Met reflectie'],
                ['name' => 'Valharnas', 'unit' => 'stuk', 'description' => '2 bevestigingspunten'],
                ['name' => 'Veiligheidslijn 2m', 'unit' => 'stuk', 'description' => 'Met valdemper'],
                ['name' => 'Gasdetectiemeter 4-gas', 'unit' => 'stuk', 'description' => 'O₂, CH₄, H₂S, CO'],
                ['name' => 'Handontsmetting gel', 'unit' => 'fles', 'description' => '500ml met pomp'],
                ['name' => 'EHBO-kit standaard', 'unit' => 'stuk', 'description' => 'BHV koffer B'],
                ['name' => 'Karabijnhaken', 'unit' => 'stuk', 'description' => 'Automatische sluiting'],
            ],
            
            // Gereedschap
            'Gereedschap' => [
                ['name' => 'Dopsleutelset metrisch', 'unit' => 'set', 'description' => '8-32mm 1/2" aansluiting'],
                ['name' => 'Dopsleutelset inch', 'unit' => 'set', 'description' => '3/8"-1¼" ½" aansluiting'],
                ['name' => 'Ringsleutelset', 'unit' => 'set', 'description' => '8-22mm 12-delig'],
                ['name' => 'Steeksleutelset', 'unit' => 'set', 'description' => '6-32mm 20-delig'],
                ['name' => 'Momentsleutel 20-100Nm', 'unit' => 'stuk', 'description' => '1/2" met certificaat'],
                ['name' => 'Momentsleutel 40-200Nm', 'unit' => 'stuk', 'description' => '1/2" met certificaat'],
                ['name' => 'Inbussleutelset metrisch', 'unit' => 'set', 'description' => '1.5-10mm lang model'],
                ['name' => 'Inbussleutelset inch', 'unit' => 'set', 'description' => '1/16-3/8 lang model'],
                ['name' => 'Schroevendraaierset plat', 'unit' => 'set', 'description' => '3-10mm geïsoleerd'],
                ['name' => 'Schroevendraaierset kruiskop', 'unit' => 'set', 'description' => 'PH0-PH3 geïsoleerd'],
                ['name' => 'Schroevendraaierset Torx', 'unit' => 'set', 'description' => 'T10-T40 geïsoleerd'],
                ['name' => 'Combinatietang', 'unit' => 'stuk', 'description' => '180mm geïsoleerd'],
                ['name' => 'Waterpomptang', 'unit' => 'stuk', 'description' => '250mm Cobra'],
                ['name' => 'Kniptang', 'unit' => 'stuk', 'description' => '160mm zijkniptang'],
                ['name' => 'Punttang', 'unit' => 'stuk', 'description' => '200mm gebogen'],
                ['name' => 'Krimptang', 'unit' => 'stuk', 'description' => 'Voor kabelschoenen'],
                ['name' => 'Kabelstripper', 'unit' => 'stuk', 'description' => 'Automatisch 0.5-6mm²'],
                ['name' => 'Hamer 300g', 'unit' => 'stuk', 'description' => 'Klauwhamer'],
                ['name' => 'Kunststofhamer', 'unit' => 'stuk', 'description' => '35mm nylon'],
                ['name' => 'Moker 3kg', 'unit' => 'stuk', 'description' => 'Met fiberglas steel'],
                ['name' => 'Breekijzer 600mm', 'unit' => 'stuk', 'description' => 'Koevoet'],
                ['name' => 'Haakse slijper 125mm', 'unit' => 'stuk', 'description' => '1400W'],
                ['name' => 'Accuboormachine 18V', 'unit' => 'stuk', 'description' => 'Met 2 accu\'s'],
                ['name' => 'Klopboormachine', 'unit' => 'stuk', 'description' => '850W SDS+'],
                ['name' => 'Schroefmachine 18V', 'unit' => 'stuk', 'description' => 'Slagschroever'],
                ['name' => 'Slagmoersleutel pneumatisch', 'unit' => 'stuk', 'description' => '1/2" 1350Nm'],
                ['name' => 'Waterpas 60cm', 'unit' => 'stuk', 'description' => 'Aluminium'],
                ['name' => 'Laserwaterpas', 'unit' => 'stuk', 'description' => 'Kruislijn zelfnivellerend'],
                ['name' => 'Meetlint 5m', 'unit' => 'stuk', 'description' => 'Automatisch oprolbaar'],
                ['name' => 'Rolmeter 30m', 'unit' => 'stuk', 'description' => 'Fiberglas band'],
                ['name' => 'Spanningstester', 'unit' => 'stuk', 'description' => '12-1000V AC/DC'],
                ['name' => 'Multimeter digitaal', 'unit' => 'stuk', 'description' => 'TRMS CAT III'],
            ],
            
            // Technische onderhoudsmaterialen
            'Technische onderhoudsmaterialen' => [
                ['name' => 'Smeervet foodgrade', 'unit' => 'kg', 'description' => 'NSF H1 patroon 400g'],
                ['name' => 'Smeervet EP2', 'unit' => 'kg', 'description' => 'Universeel patroon 400g'],
                ['name' => 'Smeervet lithium', 'unit' => 'kg', 'description' => 'Waterbestendig 400g'],
                ['name' => 'O-ring assortiment NBR', 'unit' => 'doos', 'description' => '225 stuks metrisch'],
                ['name' => 'O-ring 50x3mm', 'unit' => 'stuk', 'description' => 'NBR 70 shore'],
                ['name' => 'O-ring 100x5mm', 'unit' => 'stuk', 'description' => 'NBR 70 shore'],
                ['name' => 'Pakking papier', 'unit' => 'vel', 'description' => '500x500x1mm'],
                ['name' => 'Pakking rubber', 'unit' => 'vel', 'description' => '500x500x3mm'],
                ['name' => 'Pakking EPDM', 'unit' => 'vel', 'description' => '500x500x5mm'],
                ['name' => 'PTFE tape', 'unit' => 'rol', 'description' => '12mm x 12m'],
                ['name' => 'Loctite 243', 'unit' => 'fles', 'description' => 'Schroefdraadborging 50ml'],
                ['name' => 'PVC slang 25mm', 'unit' => 'meter', 'description' => 'Transparant'],
                ['name' => 'PE slang 32mm', 'unit' => 'meter', 'description' => 'Zwart HDPE'],
                ['name' => 'Persslang 50mm', 'unit' => 'meter', 'description' => '10 bar'],
                ['name' => 'PVC bocht 90° 110mm', 'unit' => 'stuk', 'description' => 'SN4'],
                ['name' => 'PVC T-stuk 110mm', 'unit' => 'stuk', 'description' => 'SN4 87°'],
                ['name' => 'Geka koppeling 1"', 'unit' => 'stuk', 'description' => 'Messing'],
                ['name' => 'Camlock koppeling A 2"', 'unit' => 'stuk', 'description' => 'Aluminium'],
                ['name' => 'V-snaar SPZ 1250', 'unit' => 'stuk', 'description' => '10x8x1250mm'],
                ['name' => 'Ketting 08B-1', 'unit' => 'meter', 'description' => 'Simplex 1/2"'],
                ['name' => 'Kabel 3x2.5mm²', 'unit' => 'meter', 'description' => 'XVB'],
                ['name' => 'Wartel M20', 'unit' => 'stuk', 'description' => 'IP68 kabel 10-14mm'],
                ['name' => 'Wartel M25', 'unit' => 'stuk', 'description' => 'IP68 kabel 13-18mm'],
                ['name' => 'Aansluitdoos 150x110', 'unit' => 'stuk', 'description' => 'IP65 met wartels'],
                ['name' => 'Pneumatische koppeling 8mm', 'unit' => 'stuk', 'description' => 'Push-in recht'],
                ['name' => 'Trillingsdemper M8', 'unit' => 'stuk', 'description' => 'Type A 40x30mm'],
            ],
            
            // Specifieke Aquafin tools
            'Specifieke Aquafin/riolering gerelateerde tools' => [
                ['name' => 'Putdekselhaak standaard', 'unit' => 'stuk', 'description' => 'Gesmeed staal'],
                ['name' => 'Mangatopener', 'unit' => 'stuk', 'description' => 'Met hendel'],
                ['name' => 'Rioolcamera 30m', 'unit' => 'stuk', 'description' => 'Kleur met teller'],
                ['name' => 'Inspectiecamera flexibel', 'unit' => 'stuk', 'description' => '5m WiFi'],
                ['name' => 'Gasdetector H₂S', 'unit' => 'stuk', 'description' => 'Enkelvoudig 0-100ppm'],
                ['name' => 'Gasdetector 4-gas', 'unit' => 'stuk', 'description' => 'H₂S, CO, O₂, LEL'],
                ['name' => 'Ontstoppingsveer 10m', 'unit' => 'stuk', 'description' => '8mm spiraal'],
                ['name' => 'Ontstoppingsveer 15m', 'unit' => 'stuk', 'description' => '10mm spiraal'],
                ['name' => 'Hogedrukreiniger', 'unit' => 'stuk', 'description' => '150 bar benzine'],
                ['name' => 'Slangenwagen 50m', 'unit' => 'stuk', 'description' => 'Voor 1/2" slang'],
                ['name' => 'Dompelpomp 400V', 'unit' => 'stuk', 'description' => 'Vuilwater 2"'],
                ['name' => 'Dompelpomp 230V', 'unit' => 'stuk', 'description' => 'Vlakzuiger'],
                ['name' => 'Rioolstop 100mm', 'unit' => 'stuk', 'description' => 'Opblaasbaar'],
                ['name' => 'Rioolstop 150mm', 'unit' => 'stuk', 'description' => 'Opblaasbaar'],
                ['name' => 'Rioolstop 200mm', 'unit' => 'stuk', 'description' => 'Opblaasbaar'],
                ['name' => 'Vlotterschakelaar', 'unit' => 'stuk', 'description' => '5m kabel'],
                ['name' => 'Niveaumeting ultrasoon', 'unit' => 'stuk', 'description' => '0-10m 4-20mA'],
                ['name' => 'Niveaumeting radar', 'unit' => 'stuk', 'description' => '0-15m HART'],
                ['name' => 'Staalnamepot 1L', 'unit' => 'stuk', 'description' => 'RVS met hengsel'],
                ['name' => 'Monsternameapparaat', 'unit' => 'stuk', 'description' => 'Telescopisch 3m'],
            ],
            
            // Diversen
            'Diversen / Verbruiksgoederen' => [
                ['name' => 'Tie-wraps 200x3.6mm', 'unit' => 'zak', 'description' => '100 stuks zwart'],
                ['name' => 'Tie-wraps 300x4.8mm', 'unit' => 'zak', 'description' => '100 stuks zwart'],
                ['name' => 'Tie-wraps 370x7.6mm', 'unit' => 'zak', 'description' => '100 stuks zwart'],
                ['name' => 'Kabelschoenen 6mm²', 'unit' => 'doos', 'description' => '100 stuks ring M8'],
                ['name' => 'Kabelschoenen 10mm²', 'unit' => 'doos', 'description' => '100 stuks ring M10'],
                ['name' => 'Markeringstape rood/wit', 'unit' => 'rol', 'description' => '50mm x 66m'],
                ['name' => 'Markeringstape geel/zwart', 'unit' => 'rol', 'description' => '50mm x 66m'],
                ['name' => 'Siliconenkit transparant', 'unit' => 'koker', 'description' => '310ml sanitair'],
                ['name' => 'Siliconenkit grijs', 'unit' => 'koker', 'description' => '310ml universeel'],
                ['name' => 'Lijm 2-componenten', 'unit' => 'set', 'description' => 'Epoxy 25ml'],
                ['name' => 'Reinigingsdoekjes', 'unit' => 'doos', 'description' => '200 doeken'],
                ['name' => 'WD-40', 'unit' => 'bus', 'description' => '400ml spray'],
                ['name' => 'Contactspray', 'unit' => 'bus', 'description' => '200ml'],
                ['name' => 'Kettingspray', 'unit' => 'bus', 'description' => '400ml'],
                ['name' => 'Duct tape', 'unit' => 'rol', 'description' => '50mm x 50m zilver'],
                ['name' => 'Isolatietape', 'unit' => 'rol', 'description' => '19mm x 20m zwart'],
                ['name' => 'Batterijen AA', 'unit' => 'pak', 'description' => '4 stuks alkaline'],
                ['name' => 'Batterijen AAA', 'unit' => 'pak', 'description' => '4 stuks alkaline'],
                ['name' => 'Accu 18V 5Ah', 'unit' => 'stuk', 'description' => 'Li-ion reserveaccu'],
                ['name' => 'Relais 24V', 'unit' => 'stuk', 'description' => '4 wisselcontacten'],
                ['name' => 'PLC module DI', 'unit' => 'stuk', 'description' => '8 digitale ingangen'],
                ['name' => 'Motor 0.75kW', 'unit' => 'stuk', 'description' => '400V 1450rpm B3'],
                ['name' => 'Persluchtfles', 'unit' => 'stuk', 'description' => '10L 200bar'],
            ],
        ];

        // Loop door alle categorieën en voeg materialen toe
        foreach ($materials as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                foreach ($items as $item) {
                    Material::create([
                        'category_id' => $category->id,
                        'name' => $item['name'],
                        'description' => $item['description'] ?? null,
                        'unit' => $item['unit'],
                        'is_available' => true,
                        'minimum_stock' => rand(5, 20), // Random minimum voorraad
                        'price' => rand(5, 500) / 10, // Random prijs tussen 0.50 en 50.00
                    ]);
                }
            }
        }

        // Voeg enkele materialen toe met specifieke leveranciers en artikelnummers
        $specificMaterials = Material::take(20)->get();
        $suppliers = ['Fabory', 'Eriks', 'RS Components', 'Rexel', 'Solar'];
        
        foreach ($specificMaterials as $material) {
            $material->update([
                'supplier' => $suppliers[array_rand($suppliers)],
                'article_number' => 'ART-' . str_pad(rand(1000, 9999), 6, '0', STR_PAD_LEFT),
            ]);
        }
    }
}