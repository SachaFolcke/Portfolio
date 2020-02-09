function getRandom403String() {

    const strings = [
        "Vous n'avez pas le droit de toucher à ça !",
        "Un invité ne peut rien modifier, et heureusement !",
        "L'accès vous est (malheureusement pour vous ?) refusé.",
        "Vous avez vraiment cru pouvoir toucher à ça ? C'est honteux.",
        "N'essayez même pas.",
        "On ne touche qu'avec les yeux !",
        "Il vous faudra un peu plus de droits pour espérer toucher à ça.",
        "Action impossible.",
        "Beep boop, accès refusé.",
        "Dans un univers parallèle peut-être, les invités pourraient modifier des choses.",
        "N'insistez pas, non c'est non.",
        "Vous avez activé ma carte piège !",
        "Je savais que vous alliez finir par cliquer dessus.",
        "Peut-être qu'en insistant un peu, cliquer sur ce bouton produira quelque chose.",
        "J'ai pensé à tout ! ... Enfin, j'espère !",
        "Et si vous réessayiez, mais avec un vrai compte, cette fois-ci ?",
    ];

    var random = Math.floor(Math.random() * strings.length);

    return "\"" + strings[random] + "\"\n\nAction impossible en tant qu'invité.";
}
