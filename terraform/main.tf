terraform {
  required_providers {
    linode = {
      source  = "linode/linode"
      version = "~> 1.29.4"
    }
    null = {
      source  = "hashicorp/null"
      version = "~> 3.2.1"
    }
  }
}

provider "linode" {
  token = var.linode_token
}

resource "linode_instance" "server" {
  label     = "app-server"
  image     = "linode/ubuntu24.04"
  region    = "ap-south"
  type      = "g6-nanode-1"
  root_pass = var.root_pass

  stackscript_data = {}
}

resource "null_resource" "provision_docker" {
  depends_on = [linode_instance.server]

  connection {
    type     = "ssh"
    user     = "root"
    host     = linode_instance.server.ip_address
    password = var.root_pass      # ✅ Use the same password set in Linode
    timeout  = "5m"
  }

 provisioner "remote-exec" {
  inline = [
    # Enable debug mode
    "set -x",

    # Show OS info and PATH
    "echo '🔍 OS Info:' && cat /etc/os-release",
    "echo '📂 PATH:' && echo $PATH",

    # Check if apt exists
    "if ! command -v apt >/dev/null 2>&1; then echo '❌ apt not found. Unsupported OS for this script.' && exit 1; fi",

    # Wait for apt lock
    "while sudo fuser /var/lib/dpkg/lock >/dev/null 2>&1; do echo '⏳ Waiting for apt lock...'; sleep 3; done",

    # Update apt and install dependencies
    "sudo apt update && sudo apt install -y curl ca-certificates gnupg lsb-release software-properties-common",

    # Install latest Docker from official repo
    "curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg",
    "echo \"deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable\" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null",
    "sudo apt update && sudo apt install -y docker-ce docker-ce-cli containerd.io",

    # Install latest Docker Compose v2
    "curl -SL https://github.com/docker/compose/releases/download/v2.32.2/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose",
    "chmod +x /usr/local/bin/docker-compose",

    # Install latest Git from PPA
    "sudo add-apt-repository ppa:git-core/ppa -y",
    "sudo apt update && sudo apt install -y git",

    # Clone and prepare app
    "git clone https://github.com/zamibd/master.git /root/master",
    "cd /root/master/app",
    "rm -f index.php",
    "git clone https://github.com/zamibd/cloud-sms.git /root/master/app/cloud-sms",
    "cp -a /root/master/app/cloud-sms/. /root/master/app/",
    "rm -rf /root/master/app/cloud-sms",

    # Start Docker containers
    "cd /root/master && docker compose up -d --build"
  ]
}
}

output "server_ip" {
  value = linode_instance.server.ip_address
}