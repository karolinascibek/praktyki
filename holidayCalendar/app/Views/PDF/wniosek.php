<div class="container">
    <div class="nameAndDate">
        <div class='name' ><?php echo $name." ".$last_name; ?></div>
        <div class='fieldDate'>Olsztyn,12.07.2020</div>
    </div>
    <div class="header">
        <div class='name'>imię i nazwisko pracownika</div>
        <div class='date'>miejscowość, data złożenia podania</div>
    </div>
    <div class="nameCompany">
        <div> <?php echo $company.' nip:'.$nip; ?></div>
    </div>
    <div class="company">
        <div>nazwa i nip firmy</div>
    </div>
    <div class="application">
        <p><strong>WNIOSEK</strong> </p>
        <p>Zwracam się z prośbą o udzielenie urlopu</p>
        <p><?php echo $type; ?></p>
        <p>za rok <?php echo $year;?> w okresie od <?php echo $from?> do <?php echo $to ?> tj. <?php echo $days;?> dni roboczych.</p>
    </div>
    <div class="employee">
        <div>podpis pracownika</div>
    </div>
    <div class="agree">
        <div>WYRAŻAM ZGODE / NIE WYRAŻAM ZGODY* na udzielenie urlopu w w.w. terminie.</div>
    </div>
    <div class="employer">
        <div>Podpis pracodawcy</div>
    </div>
</div>
