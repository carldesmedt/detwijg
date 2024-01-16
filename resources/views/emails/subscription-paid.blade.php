<p>Beste {{ $sub->name}}, </p>
<p> Wij hebben jouw betaling ontvangen en bevestigen de inschrijving voor {{ $event->name }} . <br>
Wij hebben alvast een plaats voor jou gereserveerd.</p>
<p> Detail van je reservatie vind je hieronder</p>

<ul>
    <li>Naam: <span @style(['font-weight: bold'])>{{$sub->name}}</span></li>
    <li>Ploegnaam: <span @style(['font-weight: bold'])>{{$sub->team}}</span></li>
    <li>e-mail: <span @style(['font-weight: bold'])>{{$sub->email}}</span></li>
    <li>Status betaling: <span @style(['font-weight: bold'])>{{$sub->status}}</span></li>
    
    
</ul>
<p>Wij kijken uit naar uw deelname</p>
<p>mvg,<br>
Ouderraad De Twijg</p>