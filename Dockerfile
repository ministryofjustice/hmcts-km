FROM mojdigital/wordpress-base:latest

# Install node 10
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y nodejs && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /var/tmp/* /init

ADD . /bedrock

WORKDIR /bedrock

ARG COMPOSER_USER
ARG COMPOSER_PASS

# Set execute bit permissions before running build scripts
RUN chmod +x bin/* && sleep 1 && \
    make deep-clean && \
    bin/composer-auth.sh && \
    npm install -g bower gulp-cli && echo "{ \"allow_root\": true }" > /root/.bowerrc && \
    make build && \
    rm -f auth.json
