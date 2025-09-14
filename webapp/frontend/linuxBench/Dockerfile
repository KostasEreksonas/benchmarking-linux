FROM node:18.20.6-slim as build-env
LABEL authors="kostas"
LABEL desc="linuxBench webapp"
WORKDIR linuxBench/
COPY ./linuxBench/ .

EXPOSE 4200

RUN npm install -g @angular/cli
RUN npm install

RUN ng build
CMD ng serve --public-host 0.0.0.0
