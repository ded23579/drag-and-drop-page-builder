#!/bin/bash
# PAGE BUILDER VERIFICATION CHECKLIST
# Run this to verify everything is working

echo "=========================================="
echo "PAGE BUILDER - VERIFICATION CHECKLIST"
echo "=========================================="
echo ""

# Test 1: Routes
echo "✓ Test 1: Routes Registered"
php artisan route:list | grep builder | grep -q "builder.index" && echo "  ✓ Dashboard route exists" || echo "  ✗ Dashboard route missing"
php artisan route:list | grep builder | grep -q "builder.create" && echo "  ✓ Create route exists" || echo "  ✗ Create route missing"
php artisan route:list | grep builder | grep -q "builder.edit" && echo "  ✓ Edit route exists" || echo "  ✗ Edit route missing"
echo ""

# Test 2: Database
echo "✓ Test 2: Database"
php artisan tinker <<EOF
\$count = App\Models\Page::count();
echo "  ✓ Pages table has: " . \$count . " pages\n";
\$last = App\Models\Page::latest()->first();
if (\$last) echo "  ✓ Latest: " . \$last->title . " (ID: " . \$last->id . ")\n";
exit;
EOF
echo ""

# Test 3: Views
echo "✓ Test 3: Views Exist"
[ -f "resources/views/builder/index.blade.php" ] && echo "  ✓ index.blade.php exists" || echo "  ✗ index.blade.php missing"
[ -f "resources/views/builder/create.blade.php" ] && echo "  ✓ create.blade.php exists" || echo "  ✗ create.blade.php missing"
[ -f "resources/views/builder/edit.blade.php" ] && echo "  ✓ edit.blade.php exists" || echo "  ✗ edit.blade.php missing"
echo ""

# Test 4: Model
echo "✓ Test 4: Model"
[ -f "app/Models/Page.php" ] && echo "  ✓ Page model exists" || echo "  ✗ Page model missing"
grep -q "generateSlug" app/Models/Page.php && echo "  ✓ generateSlug method exists" || echo "  ✗ generateSlug method missing"
echo ""

# Test 5: Controller
echo "✓ Test 5: Controller"
[ -f "app/Http/Controllers/PageBuilderController.php" ] && echo "  ✓ PageBuilderController exists" || echo "  ✗ PageBuilderController missing"
grep -q "function index" app/Http/Controllers/PageBuilderController.php && echo "  ✓ index() method exists" || echo "  ✗ index() missing"
grep -q "function edit" app/Http/Controllers/PageBuilderController.php && echo "  ✓ edit() method exists" || echo "  ✗ edit() missing"
echo ""

echo "=========================================="
echo "✓ VERIFICATION COMPLETE"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Open: http://127.0.0.1:8000/builder"
echo "2. Click: '+ Create New Page'"
echo "3. Edit: Use drag & drop to add blocks"
echo "4. Save: Auto-saves every 3 seconds"
echo "5. Publish: Toggle to make public"
echo ""
