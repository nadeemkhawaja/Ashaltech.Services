# Ashaltech Services — ashaltech.io

Professional services website for Ashaltech Services: Cisco data center networking (ACI, NDFC/VXLAN, Nexus), UCS compute, MDS storage networking, VMware virtualization, and AI-ready infrastructure consulting.

## Files

| File | Purpose |
|---|---|
| `index.html` | The entire site — single file, self-contained HTML/CSS/JS + JSON-LD structured data |
| `logo.svg` | Brand mark (used in nav, footer, favicon, and 404 page) |
| `contact.php` | Contact form mail handler (requires PHP hosting) |
| `.htaccess` | Forces HTTPS, branded 404, compression, caching, security headers |
| `404.html` | Branded "page not found" page |
| `robots.txt` / `sitemap.xml` | Search engine indexing |

A ready-to-upload archive of all of the above is kept one level up as `ashaltech-hostinger-upload.zip`.

## Deploying to Hostinger (recommended)

1. In hPanel, use **Upload backup files** (or File Manager / FTP) to upload `ashaltech-hostinger-upload.zip` into `public_html/` and extract it there — all seven files should sit directly in `public_html/`.
2. Create the mailboxes **info@ashaltech.io** and **no-reply@ashaltech.io** under **Emails** for the domain. The form handler sends from `no-reply@` to `info@`; both existing on the domain keeps delivery reliable.
3. Point the `ashaltech.io` domain at Hostinger (nameservers or A record from hPanel → Domains).
4. Test the contact form after go-live: submit an inquiry and confirm it arrives at info@ashaltech.io. If PHP `mail()` delivery is unreliable, switch `contact.php` to SMTP via PHPMailer using the Hostinger mailbox credentials.

### Form delivery — how it works

The form tries two paths in order, both delivering to **info@ashaltech.io**:

1. `contact.php` on the same host (PHP `mail()`) — works on Hostinger.
2. **FormSubmit relay** (`formsubmit.co`) — automatic fallback that works on any host, including static ones.

**One-time activation required:** the first submission that goes through FormSubmit triggers a confirmation email to info@ashaltech.io — open it and click the activation link once. After that, submissions are delivered normally.

## Local preview

```bash
php -S localhost:8000        # form works (requires local PHP)
# or
python3 -m http.server 4173  # static preview only; form falls back to a mailto notice
```

## GitHub Pages note

GitHub Pages is static and cannot run `contact.php` — on Pages the form shows a "email us directly" fallback instead of sending. Full functionality requires the Hostinger (PHP) deployment.
