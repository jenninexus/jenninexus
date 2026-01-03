#!/bin/bash
echo "=== Creating Backup Admin User (jenni) ==="
echo ""

# Create jenni user if doesn't exist
if ! id -u jenni >/dev/null 2>&1; then
    echo "Creating jenni user..."
    useradd -m -s /bin/bash jenni
    echo "✅ User jenni created"
else
    echo "✅ User jenni already exists"
fi

# Setup SSH for jenni user
mkdir -p /home/jenni/.ssh
touch /home/jenni/.ssh/authorized_keys
chmod 700 /home/jenni/.ssh
chmod 600 /home/jenni/.ssh/authorized_keys

# Add the same SSH key to jenni user
KEY="ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIClseVXGI3eIDvUUjMo5cTNjUIGSEQFN2WpGczxGtDiO jennidrop projects"
if ! grep -qxF "$KEY" /home/jenni/.ssh/authorized_keys; then
    echo "$KEY" >> /home/jenni/.ssh/authorized_keys
    echo "✅ SSH key added to jenni user"
else
    echo "✅ SSH key already present for jenni"
fi

# Fix ownership
chown -R jenni:jenni /home/jenni/.ssh

# Give jenni passwordless sudo
if [ ! -f /etc/sudoers.d/jenni ]; then
    echo 'jenni ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/jenni
    chmod 440 /etc/sudoers.d/jenni
    echo "✅ Passwordless sudo configured for jenni"
else
    echo "✅ Sudo already configured for jenni"
fi

echo ""
echo "=== Backup User Status ==="
echo "User: jenni"
echo "SSH Key: Same as root (id_jennidrop.openssh)"
echo "Sudo: NOPASSWD:ALL"
echo "Home: /home/jenni"
echo ""
echo "You can now login as:"
echo "  ssh jenni@jennidrop"
echo "  ssh jenni@64.23.141.41"
echo ""
echo "This provides a backup way to access the server if root account has issues."
echo ""
