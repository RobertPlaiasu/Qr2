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
        <h2>Ne pare rău că v-ați uitat parola :(</h2>
        <p>Vă rugăm să apăsați pe buttonul de mai jos pentru a fi redirecționat pe pagina unde vă puteți schimba parola</p>
        <a href="{{ $url }}" class="btn">Resetează parola</a>
        <p>
            Dacă nu tu ești cel care a solicitat resetarea parolei, doar ignoră acest email <br>
            Toate cele bune, <br>
            Digital menu
        </p>
        <hr>
        <p>Dacă ai problemă apasând buttonul „Resetează parola”, accesează manual următorul link <a href="{{ $url }}"> {{ $url }} </a> </p>
    </div>
</div>
