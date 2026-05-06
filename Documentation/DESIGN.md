# ReTide Design & Brand Identity

This document outlines the core design elements, brand identity, and UI/UX guidelines for the ReTide web application. It serves as a reference for developers and designers to ensure visual consistency across the platform.

## 1. Brand Logo
- **Primary Logo File:** `public/assets/img/ReTide_Logo.png`
- **Usage:** The logo is primarily used in the top navigation bar and footer. It is designed to stand out against the dark, ocean-themed background.

## 2. Typography
The application utilizes a clean, modern typography stack to ensure readability and a premium feel.

### Primary Font: Poppins
- **Source:** Google Fonts
- **Weights Used:** 100 through 900 (Italic and Normal)
- **Usage:** Used globally as the primary font for headings, body text, buttons, and UI elements.
- **Fallback Stack:** `"Poppins", -apple-system, BlinkMacSystemFont, "Times New Roman", Times, serif`

### Secondary Font: Instrument Sans
- **Source:** Tailwind CSS Configuration (`resources/css/app.css`)
- **Usage:** Configured as the default `--font-sans` within the Tailwind utility classes for supplementary UI text.

## 3. Color Palette
ReTide employs a sleek dark theme by default. This not only provides a premium aesthetic but also makes the vibrant accent colors pop, representing the ocean and sustainability.

### Primary Colors
| Color Name | Hex Code | Usage |
| :--- | :--- | :--- |
| **Brand Teal / Accent** | `#63cfc0` | Primary Call-to-Action buttons, Active Links, Headings, Text Shadows/Glows |
| **Main Background** | `#000000` | Global application background (`.defaultTheme`) |

### Secondary Colors
| Color Name | Hex Code | Usage |
| :--- | :--- | :--- |
| **Card Background** | `#0b0b0b` | Background for Blog cards, About sections, and Form containers |
| **Primary Text** | `#ffffff` | Standard body text and active navigation items |
| **Secondary Text** | `#c7c7c7` | Subtitles, descriptions, and paragraph text |
| **Placeholder Text** | `#777777` | Input field placeholders |

### UI & Border Colors
| Color Name | Hex Code | Usage |
| :--- | :--- | :--- |
| **Card Borders** | `#222222` | Borders around cards and primary sections |
| **Input Borders** | `#333333` | Borders for input fields, selects, and textareas |
| **Destructive Action** | `#c75151` | Delete buttons, warnings, and error states |
| **Destructive Hover** | `#ff6666` | Hover state for destructive actions |

## 4. UI Components & Shapes
Consistency in component shapes is crucial for maintaining ReTide's identity.

- **Buttons (`.btn`, `.cta-button`):** Pill-shaped with a `25px` border-radius. They use bold font weights and smooth background color transitions on hover (`0.3s ease`).
- **Cards & Containers:** Slightly rounded corners with a `16px` border-radius and a subtle `1px` solid border (`#222222`). This creates a distinct separation from the pure black background.
- **Form Inputs:** Rounded rectangles with a `10px` border-radius, dark backgrounds (`#000000`), and subtle borders (`#333333`).

## 5. Interactions & Animations
ReTide leverages modern web animation libraries to create a dynamic and fluid user experience.

- **Smooth Scrolling:** Powered by [Lenis](https://lenis.studiofreight.com/) to provide a buttery-smooth scrolling experience.
- **Scroll Animations:** Handled via [GSAP](https://gsap.com/) and **ScrollTrigger**. Elements reveal and animate naturally as the user scrolls down the page.
- **Hover Effects:** Navigation links and buttons utilize subtle color transitions. Active and hovered links receive a glowing text-shadow effect (`text-shadow: 0 0 5px #63cfc0`).

## 6. CSS Architecture
- **Tailwind CSS v4:** Used for rapid UI development, layout structures, and standardized spacing.
- **Custom CSS (`public/assets/css/styles.css`):** Handles complex layouts, specific gradient overlays (e.g., `.smoothen-gradient-box`), and custom global theme rules (`.defaultTheme`, `.homepage`) that fall outside standard utility class behavior.
