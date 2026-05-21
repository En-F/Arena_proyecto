FROM ubuntu/bind9:latest

# Instalamos herramientas de red para debug (opcional)
RUN apt-get update && apt-get install -y dnsutils

COPY config/named.conf /etc/bind/named.conf
COPY config/arena.com.zone /etc/bind/arena.com.zone

EXPOSE 53/tcp
EXPOSE 53/udp
