FROM node:18.20.6-slim as build-env
LABEL authors="kostas"
LABEL desc="linuxBench webapp"
WORKDIR /linuxBench
COPY . /linuxBench

RUN npm install
RUN npm install -g @angular/cli

RUN ng build
CMD ng serve --host 0.0.0.0 --port 4200
