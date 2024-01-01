<p>Beste {{ $sub->name}}, </p>
<p> Wij danken u voor uw inschrijving voor {{ $event->name }} . <br>
Wij hebben alvast een plaats voor u gereserveerd.</p>
<p> Om uw inschrijving definitief te maken vragen wij u om het inschrijvingsgeld over te maken op onze rekening. Detail van uw reservatie en betalingsgegevens vindt u hieronder.</p>

<ul>
    <li>Naam: <span @style(['font-weight: bold'])>{{$sub->name}}</span></li>
    <li>Ploegnaam: <span @style(['font-weight: bold'])>{{$sub->team}}</span></li>
    <li>e-mail: <span @style(['font-weight: bold'])>{{$sub->email}}</span></li>
    <li>Bedrag inschrijving: <span @style(['font-weight: bold'])>{{$sub->fee}}</span></li>
    <li>Rekeningnummer: <span @style(['font-weight: bold'])>BE29 7340 4090 0764</span></li>
    <li>Referentie: <span @style(['font-weight: bold'])>{{$sub->reference}}</span></li>
    
</ul>
<p>Wij kijken uit naar uw deelname</p>
<p>mvg,<br>
Ouderraad De Twijg</p>