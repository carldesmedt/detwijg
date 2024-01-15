<p>Beste {{ $sub->name}}, </p>
<p> Wij danken u voor uw interesse voor {{ $event->name }} . <br>
De plaatsen zijn beperkt en intussen is de {{ $event->name }} volzet</p>
<p> Mocht er alsnog een plaats vrijkomen zullen wij u contacteren. Hieronder vind je een opsomming van jouw gegevens.</p>

<ul>
    <li>Naam: <span @style(['font-weight: bold'])>{{$sub->name}}</span></li>
    <li>Ploegnaam: <span @style(['font-weight: bold'])>{{$sub->team}}</span></li>
    <li>e-mail: <span @style(['font-weight: bold'])>{{$sub->email}}</span></li>
    <li>Telefoon: <span @style(['font-weight: bold'])>{{$sub->phone}}</span></li>
    
    
</ul>
<p>Wij kijken uit naar uw deelname</p>
<p>mvg,<br>
Ouderraad De Twijg</p>