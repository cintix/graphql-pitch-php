# GraphQL Pitch (PHP Edition)

A minimal, reflection-based GraphQL runtime written in pure PHP — inspired by the original [GraphQLPitch (C#)](https://github.com/cintix/GrapqlPitch).

The goal of this project is not to replace existing GraphQL libraries,  
but to **demonstrate how little it actually takes** to implement a working GraphQL-style system from scratch.

---

## 🚀 Features

- Reflection-based schema and type discovery  
- Recursive query execution  
- Support for `query` and `mutation` operations  
- Field arguments (`createCustomer(name: "Sara")`)  
- Nested object resolution  
- Simple AST model for types and fields  

Everything is implemented in ~400 lines of PHP.  
No external dependencies — just PHP ≥ 8.0.---


This project is a pitch — a way to show that GraphQL is not magic.
It’s simply a structured query format + introspection.

You can read the query, call matching methods, and build JSON — that’s it.
Everything else (validation, SDL, resolvers) are optional layers.
💡 Credits

Original idea and design: Michael Martinsen (Cintix)
C# prototype: GrapqlPitch


PHP implementation: a faithful port to show the same concept in another language.
⚙️ Requirements

    PHP 8.0 or higher

    No dependencies

Run example:

php examples/index.php

🧭 Next steps

Support for lists (customers { id name })

Nullable types & scalar mapping

Schema introspection

    Lightweight CLI / server mode

    "GraphQL is not complicated — it’s just structured reflection."
    — Michael Martinsen, creator of GraphQL Pitch
