**PROMPT: Convert Static Design into a Full Site Editing (FSE) WordPress Theme**

You are an expert WordPress developer.

## Objective

Convert an existing static website design (HTML/CSS/JS) into a fully functional **WordPress Full Site Editing (FSE) block theme** using the Gutenberg editor.

## Critical Requirement (DO NOT VIOLATE)

The final output must **strictly preserve the original design**:

* Layout
* Spacing
* Typography
* Colors
* Dimensions
* UI/UX structure

No visual or structural changes are allowed.

---

## Functional Requirements

1. The entire website must be fully editable using the **Gutenberg Site Editor**.
2. All content must be dynamic:

   * Text
   * Images
   * Sections
3. Users must be able to edit:

   * Padding
   * Margin
   * Alignment
   * Width and height
4. Changes made in the editor must reflect instantly on the frontend.
5. Global components must be reusable and editable:

   * Header
   * Footer

---

## Technical Requirements

### Theme Type

* Build a **block-based WordPress theme (FSE)**
* Do NOT use a classic theme approach

### Required File Structure

Include at minimum:

* style.css
* functions.php
* theme.json
* templates/

  * index.html
  * front-page.html
  * page.html
* parts/

  * header.html
  * footer.html
* patterns/ (for reusable sections)

---

## Implementation Instructions

### 1. Block Conversion

* Convert static HTML into **Gutenberg block markup**
* Use core blocks (group, heading, paragraph, image, etc.)
* Preserve all original CSS class names

---

### 2. Templates

* Create block templates:

  * index.html
  * front-page.html
  * page.html
* Use `wp:template-part` for header and footer

---

### 3. Template Parts

* Create reusable:

  * Header
  * Footer
* Ensure changes apply globally across the site

---

### 4. theme.json Configuration

* Define full design system:

  * Colors
  * Typography
  * Spacing
  * Layout widths
* Match the original design exactly

---

### 5. Block Patterns

* Convert repeating sections into **block patterns**
* Register patterns in the theme
* Ensure consistency across pages

---

### 6. Layout Protection

* Use block locking where necessary
* Prevent users from breaking layout structure
* Allow content editing but restrict structural changes

---

### 7. Styling

* Reuse the original CSS
* Ensure frontend and editor styles match
* Load editor styles using:
  add_theme_support('editor-styles')

---

### 8. Editor Experience

* Enable controls for:

  * Spacing (margin/padding)
  * Alignment
* Disable unnecessary customization that breaks design

---

## Expected Output

Provide:

1. Full theme folder structure
2. All required files with code:

   * templates
   * template parts
   * theme.json
   * functions.php
3. Example block-based HTML conversion
4. At least one block pattern example
5. Clean, production-ready code following WordPress standards

---

## Important Notes

* Do NOT redesign anything
* Do NOT simplify layout
* Do NOT replace with generic Gutenberg layouts
* Maintain pixel-perfect accuracy with the original design

---

## Goal

Deliver a fully dynamic, Gutenberg-powered WordPress FSE theme where:

* Everything is editable
* Design remains unchanged
* Users can manage the entire site visually via Site Editor
