<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="left_panel">

<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/customers">Ügyfelek<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Törzsadatok <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
          <ul class="dropdown-menu forAnimate" role="menu">
            <li><a href="/adatok">Adataim</a></li>
            <li class="divider"></li>
            <li><a href="/afatorzs">Áfatörzs</a></li>
            <li class="divider"></li>
            <li><a href="/payment">Fizetési módok</a></li>
            <li class="divider"></li>
            <li><a href="/invoicenumber">Számlatömbök</a></li>
            <li class="divider"></li>
            <li><a href="#">Termék módosítók</a></li>
          </ul>
        </li>          
        <li ><a href="/users">Felhasználók<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
        <li ><a href="/products">Termékek<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-th-list"></span></a></li>        
        <li ><a href="/invoicing">Számlázási törzsadatok<span style="font-size:16px;" class="pull-right hidden-xs "></span></a></li>
        <li ><a href="#">Lekérdezések<span style="font-size:16px;" class="pull-right hidden-xs showopacity "></span></a></li>
        <li ><a href="/dataimport">Adatimport<span style="font-size:16px;" class="pull-right hidden-xs showopacity "></span></a></li>
        <li ><a href="/logout">Kilépés<span style="font-size:16px;" class="pull-right hidden-xs showopacity "></span></a></li>
      </ul>
    </div>
  </div>
</nav>


</div>