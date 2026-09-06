# Art Theme Add CSS

Art Theme Add CSS is a PrestaShop module by Tecnoacquisti.com® that lets a
merchant add custom CSS to the active shop theme from the back office.

## Features

- Stores a custom CSS snippet for each shop.
- Adds the CSS to the `displayHeader` hook when the feature is enabled.
- Provides a back-office switch to enable or disable the custom stylesheet.
- Removes its configuration value and database table during uninstallation.

## Compatibility

The source declares module version `1.1.7`. It does not declare a PrestaShop
or PHP compatibility matrix. It uses the legacy `Module` and `HelperForm`
APIs, so compatibility must be verified on the target shop before production
use.

## Installation

1. Back up the shop database and files.
2. Upload the `artaddcss` directory, or install a ZIP containing that single
   top-level directory, through the PrestaShop back office.
3. Install the module from **Modules and Services**.
4. Open its configuration page, enter the required CSS, and enable the
   **Custom CSS Code** switch.
5. Clear the PrestaShop cache and test the storefront in the active theme.

## Configuration and security

The CSS field is intentionally rendered in the shop header. Only trusted
back-office users who are allowed to change the storefront should be granted
access to this module. Review custom CSS before saving it, especially in a
multistore installation.

The module stores its value in the `art_cssadd` database table and uses the
`ART_HEADER_FEATURE_ACTIVE` configuration key for the enable switch.

## Support

For support with an existing installation, contact
[Tecnoacquisti.com®](https://www.tecnoacquisti.com/) at
helpdesk@tecnoacquisti.com.

## Security and supply chain

Report vulnerabilities privately as described in
[SECURITY.md](https://github.com/ArteInfoRM/artaddcss/blob/main/SECURITY.md).
The dependency inventory is in
[THIRD-PARTY-NOTICES.md](https://github.com/ArteInfoRM/artaddcss/blob/main/THIRD-PARTY-NOTICES.md).
The CycloneDX SBOM is retained in the repository as release evidence and is
excluded from installation archives.

## License

This project is released under the [MIT License](https://opensource.org/license/mit/).
The complete license text is included in `LICENSE`. Third-party PrestaShop
directory guard files retain their original AFL-3.0 notices; see
`THIRD-PARTY-NOTICES.md`.
