<!DOCTYPE html>
<html>
<head>
    <title>Bulletin de paie de {{$paie->first()->user->prenom}}</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:200px;
        height:60px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Gestion de pointage</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Id du paiement : <span class="gray-color">{{$invoiceId}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">identifiant de l'employé : <span class="gray-color">{{$orderId}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Date de paiemen : <span class="gray-color">{{$orderDate}}</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">Gestion de pointage</div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Email</th>
            <th scope="col">Heurers travaillées</th>
            <th scope="col">Avances recues</th>
            <th scope="col">Montant payé</th>
            <th scope="col">Date de paiement</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">

        @foreach($paie as $paie)
            <tr>
                    <td>{{$paie->user->prenom}}</td>
                    <td>{{$paie->user->nom}}</td>
                    <td>{{$paie->user->email}}</td>
                    <td>{{$paie->nbheure_travaille}}</td>
                    <td>{{$avance}}</td>
                    <td>{{$paie->montant}}</td>
                    <td>{{$paie->created_at}}</td>

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
