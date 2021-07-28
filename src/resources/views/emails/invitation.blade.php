<style>
    .container{
        display: flex;
        padding: 5%;
        justify-content: center;
        flex-direction: column;
    }

    .bg-white
    {
        background: white;
    }

    .btn{
        text-transform: uppercase;
        padding: 1em 1.5em;
        font-size: 14px;
        color: rgba(67, 56, 202, 1);
        border: 1px solid rgba(67, 56, 202, 1);
        border-radius: 3px;
        background: white;
        text-decoration: none;
        transition: 3ms;
        margin: 1em;
    }

    p{
        margin: 2em 0;
        word-wrap: break-word:
    }

    img{
        max-width: 100px;
    }

    .btn:hover{
        background: rgba(67, 56, 202, 1);
        color: white;
    }
</style>
<div class="container">
    <img src="{{ asset('img/Logo.svg') }}" alt="Digital Menu">
    <div>
        <h2>Sunteți căutat!</h2>
        <p>
            Un restaurant dorește să vă aganjezeze. Apăsați pe butonul de mai jos pentru a putea vizualizare invitația în aplicație.
            Odată acceptă aceasta invitație vezi avea permisiunea de a modifica produse din meniu.
        </p>
        <a href="{{ env('APP_URL') . '/invitations' }}" class="btn">Vizualizează invitația</a>
        <p>
            Dacă nu doriți să acceptați invitația vă rugăm să nu ignorați acest email, deoarece invitațiile pot fi refuzate din aplicație <br>
            Toate cele bune, <br>
            Digital menu
        </p>
        <hr>
        <p>Dacă ai problemă apasând buttonul „Activează contul”, accesează manual următorul link <a href="{{ env('APP_URL') . '/invitations' }}"> {{ env('APP_URL') . '/invitations' }} </a> </p>
    </div>
</div>
