<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Правило 20 минут:</title>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
    <style>
	body {
		font-family: 'Bree Serif', cursive;
        font-size: 20px;
        counter-reset: time;
        text-align: center;
        background: rgba(156,201,123,0.9); /*rgba(186,231,153,0.9);*/
	}

    form {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

	input[type="checkbox"] {
        display: none;
		
	}

    label {
        position: relative;
        padding: 20px;
        display:inline-block;
        height: 180px;
        width: 250px;
        box-sizing: border-box;
        line-height: 24px;
        vertical-align: middle;
        visibility: hidden;
        border-radius: 50px;
        margin: 12px 40px;
        /*transition-property: content;
        transition-duration: 1.5s; */
    }


    input:checked + label{
        border: 5px solid rgba(222,252,180,1.2);;
        color: rgb(107,124,78);
        background: rgb(185,252,125);
        box-shadow: 0 0 40px #d2f700;
        counter-increment: time 20;
        visibility: visible;
    }

    div{
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .full-time::before {
        content: counter(time) ' мин из 200 минут в день!';
    }

    #sport:not(:checked) ~ #cleaning:not(:checked) ~ #self-improvement:not(:checked) ~ #concentration:not(:checked) ~
    #female:not(:checked) ~ #listening_to_yourself:not(:checked) ~ #income:not(:checked) ~ #rest:not(:checked) ~
    #reading:not(:checked) ~ #press:not(:checked) ~ .full-time::before {
        content: 'Congratulations!!!';
    }
    
    label:hover:before{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        min-width: 230px;

        background: rgba(70,113,213,0.3);
        color: rgb(70,113,213);
        -border: 1px solid;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(70,113,213,3);

        font-size: 16px;
        padding: 5px;
    }

    #sport + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #cleaning + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #self-improvement + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #concentration + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #female + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #listening_to_yourself + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #income + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #rest + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #reading + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #press + label:hover{
        color: rgba(185,252,125,0.0);
    }

    #sport + label:hover:before{
        content: 'Кто занимается спортом 20 минут в день, тому не стоит беспокоиться о своем здоровье.';
    }

    #cleaning + label:hover:before{
        content: 'Кто уделяет 20 минут в день уборке своего дома, тому не стоит переживать о беспорядке.';
    }
    #self-improvement + label:hover:before{
        content: 'Кто выделяет 20 минут в день на самоусовершенствование, тому не стоит беспокоиться о себе.';
    }
    #concentration + label:hover:before{
        content: 'Кто выделяет 20 минут в день на улучшение концентрации, тому не стоит беспокоиться о творческом кризисе.(1.Медетация.2.Прогулки на природе.3.С головой в любимое дело.)';
    }
    #female + label:hover:before{
        content: 'Кто находит 20 минут в день, чтобы выслушать о делах своей женщины, не стоит беспокоиться о проблемах в отношениях.';
    }
    #listening_to_yourself + label:hover:before{
        content: 'Кто выделяет 20 минут в день на слушание себя и ведения личных записей, тому не стоит беспокоиться о недостатке идей.';
    }
    #income + label:hover:before{
        content: 'Кто 20 минут в день работает над созданием источников дохода, тому не нужно переживать о собственном финансовом благополучии.';
    }
    #rest + label:hover:before{
        content: 'Кто выделяет 20 минут на отдых, не следует опасаться переутомления и усталости.';
    }
    #reading + label:hover:before{
        content: 'Кто читает полезную книгу хотя бы 20 минут в день, не стоит переживать о том, как стать экспертом.';
    }
    #press + label:hover:before{
        content: 'Кто качає прес 20 минут в день, в того кубики.';
    }
    </style>
</head>
<body>
	<form>
        <input type="checkbox" id="sport" checked><label for="sport"><div>спорт</div></label>
        <input type="checkbox" id="cleaning" checked><label for="cleaning"><div>уборка</div></label>
        <input type="checkbox" id="self-improvement" checked><label for="self-improvement"><div>само-усоверше-нствование</div></label>
        <input type="checkbox" id="concentration" checked><label for="concentration"><div>улучшение концентрации</div></label>
        <input type="checkbox" id="female" checked><label for="female"><div>выслушать о делах своей женщины</div></label>
        <input type="checkbox" id="listening_to_yourself" checked><label for="listening_to_yourself"><div>слушание себя и ведения личных записей</div></label>
        <input type="checkbox" id="income" checked><label for="income"><div>работает над созданием источников дохода</div></label>
        <input type="checkbox" id="rest" checked><label for="rest"><div>отдых</div></label>
        <input type="checkbox" id="reading" checked><label for="reading"><div>читает полезную книгу</div></label>
        <input type="checkbox" id="press" checked><label for="press"><div>прес</div></label>
		<p class="full-time"></p>
		<p><input type="reset" value="Reset"></p>
	</form>
</body>
</html>