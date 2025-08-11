# Imzami Docker Setup

This README provides step-by-step docker commands to set up the Imzami environment including MariaDB, Redis, PHP, Nginx, phpMyAdmin, VPN proxies, and more.

---

## 1. Create Docker Volumes and Network

```bash
# Create named volumes for persistent data storage
docker volume create db_data
docker volume create redis_data

# Create a Docker bridge network for container communication
docker network create --driver bridge imzami_net
```

---

## 2. Run MariaDB Container

```bash
docker run -d \
  --name Mariabd \
  --restart always \
  -e MYSQL_ROOT_PASSWORD="Rahmatbd@11221099" \
  -e MYSQL_DATABASE="cloudsms" \
  -e MYSQL_USER="cloudsms" \
  -e MYSQL_PASSWORD="Rahmatbd@11221099" \
  --mount source=db_data,target=/var/lib/mysql \
  --mount type=bind,source="$(pwd)/docker/mariadb/my.cnf",target=/etc/mysql/my.cnf,readonly \
  --mount type=bind,source=/var/log/mysql,target=/var/log/mysql \
  --network imzami_net \
  --health-cmd="sh -c 'mariadb-admin -u${DB_USER} -p${DB_PASSWORD} ping -h 127.0.0.1 || exit 1'" \
  --health-interval=10s \
  --health-timeout=5s \
  --health-retries=5 \
  mariadb:lts
```

> **Note:** Replace environment variables with actual values or export them in your shell before running.

---

## 3. Run Redis Container

```bash
docker run -d \
  --name Redis \
  --restart always \
  -e REDIS_PASSWORD="Rahmatbd@11221099" \
  --mount type=bind,source="$(pwd)/docker/redis/redis.conf",target=/usr/local/etc/redis/redis.conf,readonly \
  --mount source=redis_data,target=/data \
  --mount type=bind,source=/var/log/redis,target=/var/log/redis \
  --network imzami_net \
  --health-cmd="redis-cli -a '${REDIS_PASSWORD}' ping" \
  --health-interval=10s \
  --health-timeout=5s \
  --health-retries=5 \
  redis:alpine \
  redis-server /usr/local/etc/redis/redis.conf
```

---

## 4. Run PHP Container

```bash
docker run -d \
  --name php \
  --restart always \
  -w /var/www/html \
  --mount type=bind,source="$(pwd)/app",target=/var/www/html \
  --network imzami_net \
  imzami/custom-php
```

---

## 5. Run Nginx Container

```bash
docker run -d \
  --name nginx \
  --restart always \
  -p 80:80 \
  -p 443:443 \
  --mount type=bind,source="$(pwd)/app",target=/var/www/html \
  --mount type=bind,source="$(pwd)/docker/nginx/default.conf",target=/etc/nginx/conf.d/default.conf,readonly \
  --mount type=bind,source=/var/log/nginx,target=/var/log/nginx \
  --network imzami_net \
  nginx:alpine
```

---

## 6. Run phpMyAdmin Container

```bash
docker run -d \
  --name PMA \
  --restart always \
  -p 8080:80 \
  -e PMA_HOST="db" \
  -e PMA_PORT="3306" \
  --network imzami_net \
  phpmyadmin:latest
```

---

## 7. Run OpenVPN Proxy Container

```bash
docker run -d \
  --name proxy-openvpn \
  --device=/dev/net/tun \
  --cap-add=NET_ADMIN \
  --dns=45.90.28.89 --dns=45.90.30.89 \
  -e "OPENVPN_FILENAME=imzami-aes128.ovpn" \
  -e "LOCAL_NETWORK=192.168.1.0/24" \
  -e "ONLINECHECK_DELAY=300" \
  -v ./openvpn-config:/app/ovpn/config \
  -p 98:98 \
  imzami/proxy-openvpn
```

---

## 8. Run SOCKS5 Proxy Container

```bash
docker run -d \
  --name proxy-socks5 \
  --restart=always \
  --dns=45.90.28.89 \
  --dns=45.90.30.89 \
  -p 99:1080 \
  -e SOCKS5_USER=imzami \
  -e SOCKS5_PASSWORD=11221099 \
  imzami/proxy-socks5
```

---

## 9. Run IPsec VPN Server Container

```bash
echo -e "VPN_IPSEC_PSK=R01920280000\nVPN_USER=imzami\nVPN_PASSWORD=11221099\nVPN_DNS_NAME=proxy.imzami.com\nVPN_DNS_SRV1=45.90.28.89\nVPN_DNS_SRV2=45.90.30.89" > .env

docker run --name vpn-ipsec \
  --env-file .env \
  --restart=always \
  -v ikev2-vpn-data:/etc/ipsec.d \
  -v /lib/modules:/lib/modules:ro \
  -p 500:500/udp \
  -p 4500:4500/udp \
  -d --privileged \
  imzami/vpn-ipsec

# Optional: Add cron job to keep VPN alive/check link
(crontab -l 2>/dev/null; echo "*/10 * * * * curl -s https://link-ip.nextdns.io/69b4bc/54dd79b6f240abc3 > /dev/null") | crontab -
```
