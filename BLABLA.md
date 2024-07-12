# Inertia vs SPA

## Comparatif

| | Inertia | SPA | Comment |
| - | - | - | - |
| Repositories | 1 | 2 | More work to review and maintain but also manage releases and changelogs. |
| Forge sites | 1 | 2 | |
| Envoyer projects | 1 | 2 | Only 5 environments available against 10 and more manipulation to deploy. |
| Routes | 1 | 3 | Routes for the API on the backend, routes/services for the API on the frontend and routes Vue against one set of routes for the views. |
| Policies system | 1 | 2* | *We can also use the unique system with SPA but it means transmit the policies via API. |
| I18n system | 1 | 2* | *We can also use the unique system with SPA. |
| SSR | 1 | 0 | |
| Request validation | 1 | 1 | We can use Precognition with both. |
| Stores | 0* | 1 | We don't need them with Inertia. |
| API | 0* | 1 | We don't need it with Inertia except if we do a specific API for the mobile app. |

## Autre choses

### Plus rapide à utiliser

Une SPA nécessite l'initialisation d'un repo Laravel puis d'un repo Vue, sans compter la configuration des deux projets et l'installation des packages utiles et leur propre configuration.

Inertia permettant d'avoir un seul repo, c'est factuellement la méthode la plus rapide.

Pour créer une page avec une SPA il faut créer :
- Côté backend
  - Une route API
  - Un controller (request, policy en fonction du besoin)
  - Une resource pour le modèle
- Côté frontend
  - Un service pour l'API
  - Un store
  - Une route pour la view
  - La view

Avec Inertia il faut :
- Côté backend
  - Une route pour la view
  - Un controller (request, policy en fonction du besoin)
- Côté frontend
  - La view

7 contre 3, Inertia va encore une fois plus vite.

Pouvoir développer et déployer rapidement, c'est important (en particulier pour nous).

Les tests humains et les reviews sont aussi plus facile et rapide. Avec une SPA quand on veut savoir comment fonctionne une page ou un composant, on part d'une traduction ou de l'inspecteur du network pour récupérer une route de l'API, ensuite on check dans le frontend à quoi ça correspond et ensuite on peut aller dans le backend avec ces éléments pour checker le code. C'est long. Avec Inertia, il suffit de regarder l'url de la page, trouver la route, trouver le controller et basta.

Le travail de développeur est plus rapide car moins de code à écrire.

### Moins de duplicata

Avec Inertia, on a Ziggy permettant d'utiliser le nom des routes en front ce qui évite de dupliquer les urls comme ça si on doit les modifier, on peut le faire rapidement.

On n'a pas aussi à réfléchir à une belle structure API, respectant le CRUD, tout simplement parce qu'il n'y a pas d'API. On fait les routes web pour chaque page, point. Avec une SPA on doit se soucier des routes API pour chaque data, derrière les gérer dans des controllers. Ca génère beaucoup plus de code.

### Derrière ça reste du Vue

Certes on n'utilise pas de Stores, de Services API, etc. mais ces éléments ont justement été inventé pour les SPAs pour gérer la partie network, la communication entre le backend et le frontend. Avec Inertia, on n'en a pas besoin étant donné qu'Inertia est là pour s'en occuper et nous permettre de nous concentrer sur ce qui est important et apporte de la valeur à l'application.
