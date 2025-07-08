FROM php:8.2-cli

# Installer dépendances système
RUN apt-get update && apt-get install -y unzip git curl libzip-dev libonig-dev libxml2-dev

# Installer extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Installer Xdebug pour couverture de code
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copier les fichiers dans le conteneur
WORKDIR /app
COPY . .

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Exposer le port 8000 pour tests via navigateur ou Postman
EXPOSE 8000

# Lancer le serveur PHP par défaut
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
