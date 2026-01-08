FROM node:14-slim AS build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install -g node-gyp
RUN npm install
COPY . .
CMD ["npm", "run", "serve"]