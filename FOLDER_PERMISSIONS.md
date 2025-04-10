# MediaTek (JPO)

## `public/uploads/` directory permissions settings

Using Access Control Lists (ACL) permissions to make the `public/uploads/` directory writable (Linux/BSD systems):
```shell
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)

# Set permissions for future files and folders
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX uploads

# Set permissions on the existing files and folders
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX uploads
```