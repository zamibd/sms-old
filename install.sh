#!/bin/sh

set -e

echo "🔍 Detecting OS..."

OS_ID=$(grep "^ID=" /etc/os-release | cut -d'=' -f2)

# -------------------------------
# 🐧 Alpine Linux
# -------------------------------
if [ "$OS_ID" = "alpine" ]; then
  echo "🔧 Installing on Alpine Linux..."

  apk update
  apk add docker docker-cli docker-compose bash curl git gnupg unzip

  TERRAFORM_VERSION="1.8.5"
  cd /tmp && \
  curl -O https://releases.hashicorp.com/terraform/${TERRAFORM_VERSION}/terraform_${TERRAFORM_VERSION}_linux_amd64.zip && \
  unzip terraform_${TERRAFORM_VERSION}_linux_amd64.zip && \
  mv terraform /usr/local/bin/

# -------------------------------
# 🐧 Ubuntu / Debian
# -------------------------------
elif [ "$OS_ID" = "ubuntu" ] || [ "$OS_ID" = "debian" ]; then
  echo "🔧 Installing on Ubuntu/Debian..."

  sudo apt-get update && sudo apt-get install -y \
    ca-certificates \
    curl \
    gnupg \
    lsb-release \
    unzip \
    software-properties-common

  sudo install -m 0755 -d /etc/apt/keyrings
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | \
    sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

  echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
    https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | \
    sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

  sudo apt-get update
  sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

  # Terraform install
  curl -fsSL https://apt.releases.hashicorp.com/gpg | \
    sudo gpg --dearmor -o /usr/share/keyrings/hashicorp-archive-keyring.gpg

  echo "deb [signed-by=/usr/share/keyrings/hashicorp-archive-keyring.gpg] \
    https://apt.releases.hashicorp.com $(lsb_release -cs) main" | \
    sudo tee /etc/apt/sources.list.d/hashicorp.list

  sudo apt-get update && sudo apt-get install -y terraform

# -------------------------------
# ❌ Unsupported OS
# -------------------------------
else
  echo "❌ Unsupported OS: $OS_ID"
  exit 1
fi

# -------------------------------
# ✅ Done
# -------------------------------
echo ""
echo "✅ Installation Complete!"
echo "📦 Docker: $(docker --version)"
echo "📦 Terraform: $(terraform -version | head -n 1)"