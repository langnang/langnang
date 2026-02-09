docker images --filter "reference=node:*"

# REPOSITORY   TAG          IMAGE ID       CREATED       SIZE
# node         alpine       77f3c4d1f33c   3 days ago    237MB
# node         slim         0cce74a5708f   3 days ago    334MB
# node         latest       a2ed436bacdc   3 days ago    1.63GB
# node         lts-alpine   cb3143549582   4 days ago    229MB
# node         lts-slim     c407baf6e71f   4 days ago    326MB
# node         20           abcf9c98af22   3 weeks ago   1.58GB

docker images --filter "reference=*/node:*"

# REPOSITORY   TAG          IMAGE ID       CREATED       SIZE
