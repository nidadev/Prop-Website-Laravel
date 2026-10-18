<?php

namespace App\Services;

class ComparableKml
{
    public function render(array $records, string $title): string
    {
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElementNS(null, 'kml', 'http://www.opengis.net/kml/2.2');
        $xml->startElement('Document');
        $xml->writeElement('name', $title);
        $xml->writeElement('description', 'Saved comparable locations, not parcel boundaries. Records without valid coordinates are omitted. Check each source and date before use.');
        foreach ($records as $record) {
            $point = PropertyCoordinates::pair($record['latitude'] ?? null, $record['longitude'] ?? null);
            if ($point === null) { continue; }
            $xml->startElement('Placemark');
            $xml->writeElement('name', (string) (($record['address'] ?? '') ?: ($record['id'] ?? 'Land comparable')));
            $xml->startElement('ExtendedData');
            foreach (['city', 'price', 'acres', 'status', 'source', 'source_url', 'sold_date', 'updated_date'] as $key) {
                $value = $record[$key] ?? null;
                if (!is_scalar($value) || $value === '') { continue; }
                if ($key === 'source_url' && (!filter_var($value, FILTER_VALIDATE_URL) || !in_array(strtolower(parse_url($value, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true))) { continue; }
                $xml->startElement('Data');
                $xml->writeAttribute('name', $key);
                $xml->writeElement('value', (string) $value);
                $xml->endElement();
            }
            $xml->endElement();
            $xml->startElement('Point');
            $xml->writeElement('coordinates', $point[1].','.$point[0].',0');
            $xml->endElement();
            $xml->endElement();
        }
        $xml->endElement();
        $xml->endElement();
        $xml->endDocument();
        return $xml->outputMemory();
    }
}
