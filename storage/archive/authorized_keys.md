Authorized keys reference (project copy)

This file is a project-local authorized-keys reference and a convenience copy for audits.

Current keys observed (examples):
- ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIF7iRWiIWGPIf0u1aVE9UBG1KLHq71KpTe1F37SwT0Xn owner@SegoPC
- ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIHgDZH82V2jqNGJbM6qUOAqYzyJHYbE3vkrKpH1ndQ0/ main-studio-deployment
- REPLACE_WITH_PUB  <-- placeholder, replace with actual pub key

Recommended workflow: keep authorized keys management on the server and use local admin scripts. This project is self-contained; do not rely on external `shared` or `shared-deps` symlinked resources for deployment or key management.
