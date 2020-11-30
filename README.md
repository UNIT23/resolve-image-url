# IMAGE RESOLVE URL

This project show how resolve image urls automatically for entities with image files or entities with media collection (media have image file).

## Requirements
- PHP >= 7.2.5
- Mysql 5.7

## Bundles used
- [Symfony 5.1](https://github.com/symfony/symfony)
- [Api Platform](https://github.com/api-platform/api-platform)
- [LiipImagineBundle](https://github.com/liip/LiipImagineBundle)
- [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle)

## Init project

- create your `.env.local` file and edit `DATABASE_URL` to match your dev env
- run migrations : `symfony console doctrine:migrations:migrate`
- run local server : `symfony server:start`
- open : `https://127.0.0.1:8000/`
- have fun on `/api`
