FROM nginx:1.27.0

# Копіюємо конфігурацію Nginx в контейнер
COPY default.conf /etc/nginx/conf.d/

# Копіюємо веб-контент (якщо потрібно)
COPY index.html /usr/share/nginx/html/index.html

# Відкриваємо порт 80 для доступу
EXPOSE 80

RUN echo 'Hello from image'

