# FitLife Pro - WordPress Fitness Theme

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-5.8+-green.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0-red.svg)

A comprehensive WordPress theme designed for fitness websites, gyms, and exercise databases. FitLife Pro features a powerful exercise management system with advanced search, muscle group categorization, equipment filtering, and difficulty levels.

## ✨ Tính năng chính (Main Features)

### 🏠 Trang Chủ (Homepage)

1. **Hero Section với Search Bar**
   - Hero banner với gradient background động
   - Thanh tìm kiếm nâng cao với filters
   - Tìm kiếm theo: exercise name, muscle group, equipment, difficulty

2. **Dashboard Thống Kê**
   - Tổng số bài tập
   - Số lượng nhóm cơ
   - Tổng calories đốt cháy
   - Số loại thiết bị

3. **Top Exercises theo Calories**
   - Hiển thị 6 bài tập đốt cháy calories cao nhất
   - Card design với hình ảnh, calories, độ khó
   - Responsive grid layout

4. **6 Nhóm Cơ Phổ Biến (Muscle Groups)**
   - Chest, Back, Shoulders, Arms, Legs, Core
   - Icon-based design
   - Click để xem exercises theo nhóm cơ

5. **6 Loại Thiết Bị (Equipment Types)**
   - Barbell, Dumbbell, Kettlebell, Bodyweight, Machine, Cable
   - Filter exercises by equipment
   - Count số exercises per equipment

6. **3 Levels Độ Khó (Difficulty Levels)**
   - Beginner (🌱) - Màu xanh lá
   - Intermediate (🔥) - Màu vàng
   - Advanced (⚡) - Màu đỏ

7. **FAQ Section với Schema Markup**
   - Accordion-style FAQ
   - SEO-optimized với JSON-LD Schema
   - Google-friendly structure

8. **Call to Action**
   - Prominent CTA buttons
   - Gradient background
   - Mobile-responsive

## 📋 Yêu cầu hệ thống (Requirements)

- WordPress 5.8 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## 🚀 Cài đặt (Installation)

### Bước 1: Upload Theme

1. Tải theme về máy
2. Vào WordPress Admin → Appearance → Themes
3. Click "Add New" → "Upload Theme"
4. Chọn file zip của theme
5. Click "Install Now" và "Activate"

### Bước 2: Cài đặt Dữ liệu Mẫu (Sample Data)

Sau khi activate theme, bạn cần tạo:

#### 1. Muscle Groups (Nhóm Cơ)
Vào **Exercises → Muscle Groups** và thêm:
- Chest (Ngực)
- Back (Lưng)
- Shoulders (Vai)
- Arms (Tay)
- Legs (Chân)
- Core (Cơ core)
- Abs (Bụng)
- Glutes (Mông)

#### 2. Equipment Types (Thiết Bị)
Vào **Exercises → Equipment** và thêm:
- Barbell
- Dumbbell
- Kettlebell
- Bodyweight
- Machine
- Cable
- Bands
- None

#### 3. Difficulty Levels (Độ Khó)
Vào **Exercises → Difficulty Levels** và thêm:
- Beginner
- Intermediate
- Advanced

#### 4. Thêm Exercises
Vào **Exercises → Add New** và tạo bài tập với:
- Title (Tên bài tập)
- Description (Mô tả chi tiết)
- Featured Image (Hình ảnh)
- Calories Burned (Calories đốt cháy)
- Duration (Thời gian)
- Sets & Reps
- Video URL (optional)
- Chọn Muscle Group, Equipment, Difficulty

### Bước 3: Cấu hình Settings

#### Navigation Menu
1. Vào **Appearance → Menus**
2. Tạo menu mới và assign vào "Primary Menu"
3. Thêm các pages: Home, Exercises, About, Contact

#### Homepage Setup
1. Vào **Settings → Reading**
2. Chọn "A static page" cho homepage
3. Chọn page "Home" (hoặc tạo page mới với template Front Page)

#### Permalinks
1. Vào **Settings → Permalinks**
2. Chọn "Post name" structure
3. Save changes

## 📁 Cấu trúc File (File Structure)

```
fitlife-pro/
├── assets/
│   ├── css/
│   │   └── homepage.css          # Homepage styles
│   └── js/
│       └── main.js                # JavaScript functionality
├── template-parts/
│   ├── content-exercise-card.php  # Exercise card component
│   ├── content-none.php           # No results template
│   └── content.php                # Default post template
├── .gitignore                     # Git ignore file
├── archive-exercise.php           # Exercise archive template
├── footer.php                     # Footer template
├── front-page.php                 # Homepage template
├── functions.php                  # Theme functions
├── header.php                     # Header template
├── index.php                      # Main template
├── README.md                      # Documentation
├── screenshot.png                 # Theme screenshot (to be added)
├── single-exercise.php            # Single exercise template
└── style.css                      # Main stylesheet
```

## 🎨 Customization

### Colors
Để thay đổi màu sắc theme, edit trong `style.css`:

```css
:root {
    --primary-color: #FF6B35;      /* Màu chính */
    --secondary-color: #004E89;    /* Màu phụ */
    --accent-color: #1AA7EC;       /* Màu nhấn */
    --dark-color: #1A1A2E;         /* Màu tối */
}
```

### Custom Post Type: Exercise

Theme đã register custom post type "Exercise" với:
- **Taxonomies**: Muscle Group, Equipment, Difficulty
- **Meta Fields**: Calories, Duration, Sets, Reps, Video URL
- **Support**: Title, Editor, Thumbnail, Excerpt, Custom Fields

### Template Hierarchy

- Homepage: `front-page.php`
- Exercise Archive: `archive-exercise.php`
- Single Exercise: `single-exercise.php`
- Taxonomy Archive: `archive-exercise.php` (with filters)

## 🔍 Search Functionality

Theme có AJAX search với filters:
- Search by exercise name
- Filter by muscle group
- Filter by equipment
- Filter by difficulty level

Code trong `assets/js/main.js` xử lý AJAX requests.

## 📱 Responsive Design

Theme 100% responsive với breakpoints:
- Desktop: 1200px+
- Tablet: 768px - 1199px
- Mobile: < 768px

## ⚡ Performance

- Minimal CSS/JS files
- Lazy loading ready
- Optimized queries
- Caching-friendly

## 🔧 Development

### Prerequisites
- Node.js (for development tools)
- Composer (for PHP dependencies)
- Git

### Development Setup

```bash
# Clone repository
git clone <repository-url>

# Install dependencies (if any)
npm install
composer install

# Start development
npm run dev
```

## 📝 Custom Functions

### Get Statistics
```php
$stats = fitlife_get_stats();
// Returns: total_exercises, muscle_groups, equipment_types, total_calories
```

### AJAX Search
```javascript
// Frontend search with filters
$('#exercise-search-form').submit();
```

## 🐛 Troubleshooting

### Exercise không hiển thị
1. Check permalinks: Settings → Permalinks → Save
2. Verify exercises are published
3. Clear cache

### Search không hoạt động
1. Check jQuery is loaded
2. Verify AJAX URL in console
3. Check PHP errors in debug.log

### Images không hiển thị
1. Upload featured images cho exercises
2. Check file permissions
3. Regenerate thumbnails

## 🤝 Support

Để được hỗ trợ:
1. Check documentation trước
2. Search existing issues
3. Create new issue với details

## 📄 License

This theme is licensed under the GPL v2 or later.

## 👨‍💻 Credits

- **Developer**: FitLife Team
- **Icons**: Emoji icons (Unicode)
- **Fonts**: Inter (Google Fonts)

## 🔄 Changelog

### Version 1.0.0 (2025-01-21)
- Initial release
- Homepage with all required sections
- Custom post type: Exercise
- Taxonomies: Muscle Group, Equipment, Difficulty
- AJAX search functionality
- Responsive design
- FAQ with Schema markup
- Single exercise template
- Archive template with filters

## 🚀 Future Updates

Planned features:
- [ ] Workout planner
- [ ] User workout tracking
- [ ] Exercise favorites
- [ ] Print workout plans
- [ ] Advanced filtering
- [ ] Exercise comparison
- [ ] Rest timer
- [ ] Progress tracking

## 📧 Contact

For questions or feedback:
- Email: support@fitlifepro.com
- Website: https://fitlifepro.com

---

Made with ❤️ for fitness enthusiasts
