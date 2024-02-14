# Blog : Les middlewares

Dans le dernier atelier, on a géré toute la partie authentification !

C'est fort sympathique mais pas très utile à l'heure actuelle puisqu'on peut accéder à toutes les pages sans être connecté !

Pour gérer les autorisations d'accès, nous allons passer par ... des middlewares ! 🥳

Vous verrez d'autres façons de gérer les autorisations pendant votre carrière notamment avec ce qu'on appelle les [ACL](https://fr.wikipedia.org/wiki/Access_Control_List) (Access Control List). Nous ne passerons pas par ce procédé ici mais c'est important de connaître ce terme (ajoutez-le à votre lexique !).

## Le middleware Auth

Notre premier middleware va devoir se charger de vérifier si un utilisateur est authentifié ou non :

- S'il l'est, on ne fait rien (donc on le laisse passer).
- S'il ne l'est pas, on le redirige vers la page de connexion.

Vous allez donc devoir créer un middleware `Auth` sur le même modèle que `CSRF` et gérer la logique indiquée juste au dessus. Vous avez accès à une fonction `isAuth()` dans `functions.php` qui permet de vérifier facilement si un utilisateur est connecté ou non (retourne `true` si l'utilisateur est authentifié et `false` dans le cas contraire).

Attribuez ensuite ce middleware aux routes qui ne doivent être accessibles qu'aux utilisateurs authentifiés, à savoir :

- `/compte`
- `/compte/admin`
- `/deconnexion`

Pour rappel, on attribue les middlewares dans le fichier `routes.php` avec la méthode `middleware()` :

```php
Route::get('/compte', [HomeController::class, 'index'])->middleware(Auth::class),
```

## Le middleware Guest

Au tour du middleware `Guest` dont le rôle va être l'exact contraire de `Auth` !

On pourrait se dire que c'est étrange de vouloir bloquer des accès pour un utilisateur authentifié là où on accepte le passage pour un simple visiteur.

En réalité, ce middleware servira à bloquer l'accès aux pages auxquelles nous ne sommes pas sensés accéder comme les formulaires d'authentification.

Pour résumer le fonctionnement de ce middleware `Guest` :

- Si la personne est un guest (un visiteur), on ne fait rien (donc on le laisse passer).
- Si la personne est authentifiée (connectée), on le redirige vers la page `/compte`.

Vous avez accès à une fonction `isGuest()` dans `functions.php` qui permet de vérifier facilement si un utilisateur est un guest ou non (retourne `true` si l'utilisateur est un guest et `false` dans le cas contraire).

Attribuez ensuite ce middleware aux routes qui ne doivent être accessibles qu'aux guests, à savoir :

- `/inscription` (en POST et en GET)
- `/connexion`  (en POST et en GET)

## Le middleware Admin

Au tour du middleware `Admin` qui ne doit laisser passer que les utilisateurs étant des admins !

Pour le fonctionnement de ce middleware `Admin` :

- Si l'utilisateur est un admin, on ne fait rien (donc on le laisse passer).
- Si l'utilisateur n'est pas un admin, on lance une nouvelle `HttpException` avec un code d'erreur HTTP 403 (Forbidden).

Vous avez accès à une fonction `isAdmin()` dans `functions.php` qui permet de vérifier facilement si un utilisateur est un admin ou non (retourne `true` si l'utilisateur est un admin et `false` dans le cas contraire).

Attribuez ensuite ce middleware à la route `/compte/admin` qui ne doit être accessible qu'aux admins (pensez bien à aussi lui attribuer le middleware `Auth` puisqu'un admin est un utilisateur authentifié avant tout).

Pour faire vos tests, changer la valeur du champ `role` dans votre table `users` en le mettant sur `admin` pour l'utilisateur avec lequel vous souhaitez tenter d'accéder au back-office.

## Le formulaire de commentaire

Vous l'avez peut-être déjà remarqué, mais un formulaire pour commenter fait son apparition sur la page de chaque article quand l'utilisateur est connecté !

Vous allez donc devoir gérer l'ajout d'un commentaire via ce formulaire !

Commencez par créer une route avec l'URI `/articles/{slug}/comment` qui matchera avec la méthode POST et qui sera lié à l'action `comment()` du `PostController`. Cette action sera réservée aux membres authentifiés.

Ensuite, dans cette méthode, vous allez devoir :

1. Vérifier si le slug dans l'URI correspond bien à un article existant. Si ça n'est pas le cas, vous lancerez une `HttpException` pour obtenir une erreur 404.
2. Il faudra ensuite vérifier si le champ de commentaire a bien été rempli ! Si la validation échoue, on redirige l'utilisateur vers l'article qu'on a tenté de commenter.
3. Une fois que c'est fait, enregistrez le commentaire (sur le même modèle de ce que vous avez fait pour les nouveaux utilisateurs)
4. Créez une variable de session flash `status` avec la valeur `Commentaire publié`. Cette variable de session flash sera affichée sur l'interface de notre site si tout se passe correctement.
5. Retournez enfin une réponse pour rediriger l'utilisateur vers l'article qu'il vient de commenter

Fin de l'atelier ! 🥳
