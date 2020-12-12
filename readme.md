# Lighthouse GraphQL Permission

A composer package for adding GraphQL Types to support spatie/laravel-permission.

## Installation

To install the package, run the following command in your project directory:

```bash
composer require mlab817/lighthouse-graphql-permission
```

The command will also install the dependencies of the package: spatie/laravel-permission and nuwave/lighthouse.

## Set up

1. Proceed with setting up spatie/laravel-permission as usual. Add the `Spatie Permission Service Provider` in the `config/app.php` file. Also add the `HasRoles` trait in your User model. Do not forget to publish and run the migration. If you need to modify the config of the package, you may also do so by publishing the package's config file.
2. Add the `\Mlab817\LighthouseGraphQLPermission\Providers\LighthouseGraphQLPermissionServiceProvider::class` in the `config/app.php` file. This will add the service provider of the package to your app. Then, publish the `config` and `schema` files of the package by running `php artisan vendor:publish` and selecting the relevant options.
3. You can now use the package.

## Schema

```graphql
type Permission {
  id: ID
  name: String
  guard_name: String
}

type Role {
  id: ID
  name: String
  guard_name: String
}

input CreateRoleInput {
  name: String!
}

input CreatePermissionInput {
  name: String!
}

input GivePermissionToUserInput {
  user_id: ID!
  permission: String!
}

input AssignRoleInput {
  user_id: ID!
  role: String!
}

input GivePermissionToRoleInput {
  user_id: ID!
  permission: String!
}

input RevokePermissionToUserInput {
  user_id: ID!
  permission: String!
}

input RevokePermissionToRoleInput {
  role: String!
  permission: String!
}

type Mutation {
  createRole(input: CreateRoleInput!): Role!
  createPermission(input: CreatePermissionInput!): Permission!
  givePermissionToUser(input: GivePermissionToUserInput!): String
  assignRole(input: AssignRoleInput!): User!
  givePermissionToRole(input: GivePermissionToRoleInput!): String
  revokePermissionToUser(input: RevokePermissionToUserInput!): String
  revokePermissionToRole(input: RevokePermissionToRoleInput!): String
}
```
