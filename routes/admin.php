<?php


use Illuminate\Support\Facades\Route;

Route::redirect('/','admin/dashboard');

/**
 * AdminLoginController
 */
Route::controller(\App\Http\Controllers\Web\Admin\Auth\AdminLoginController::class)->group(function (){
    Route::get('login','index')->name('login.index');
    Route::post('login','login')->name('login');
});

/**
 * ResetPasswordController
 */
Route::controller(\App\Http\Controllers\Web\Admin\Auth\ResetPasswordController::class)->group(function (){
    Route::get('password/reset/{token}','showResetForm')->name('password.reset');
    Route::post('password/reset','reset')->name('reset');
});

/**
 * ForgotPasswordController
 */
Route::controller(\App\Http\Controllers\Web\Admin\Auth\ForgotPasswordController::class)->group(function (){
    Route::get('forgot/password','showLinkRequestForm')->name('forgot.password.email');
    Route::post('forgot/password','sendResetLinkEmail')->name('forgot.password.send');
});

Route::middleware('auth:admin')->group(function (){
    /**
     * AdminLoginController
     */
    Route::any('logout',[\App\Http\Controllers\Web\Admin\Auth\AdminLoginController::class,'logout'])->name('logout');

    /**
     * SettingsController
     */
    Route::controller(\App\Http\Controllers\Web\Admin\SettingsController::class)->group(function (){
        Route::get('setting','index')->name('setting.index');
        Route::post('setting','update')->name('setting.update');
    });

    /**
     * DashboardController
     */
    Route::get('dashboard',[\App\Http\Controllers\Web\Admin\DashboardController::class,'index'])->name('dashboard');

    /**
     * AdminController
     */
    Route::controller(\App\Http\Controllers\Web\Admin\AdminController::class)->group(function (){
        Route::get('admins/{id}/edit-password','editPassword')->name('admins.edit-password');
        Route::put('admins/{id}/edit-password','updatePassword')->name('admins.update-password');
    });
    Route::resource('admins', \App\Http\Controllers\Web\Admin\AdminController::class);

    /**
     * RoleController
     */
    Route::controller(\App\Http\Controllers\Web\Admin\RoleController::class)->group(function (){
        Route::get('roles/permissions','getPermissionsList')->name('roles.permissions.index');
    });
    Route::resource('roles', \App\Http\Controllers\Web\Admin\RoleController::class);

    /**
     * NotificationController
     */
    Route::controller(\App\Http\Controllers\Web\Admin\NotificationController::class)->group(function (){
        Route::post('notifications/{id}/send','send')->name('notifications.send');
    });
    Route::resource('notifications', \App\Http\Controllers\Web\Admin\NotificationController::class)->only(['index','store', 'edit', 'destroy','update']);


    /**
     * Section Routes
     */
    Route::resource('sections', \App\Http\Controllers\Web\Admin\SectionController::class);

    Route::controller(\App\Http\Controllers\Web\Admin\SharedBackgroundsController::class)->group(function (){
        Route::get('shared_backgrounds','index' )->name('shared_backgrounds.index');
        Route::get('shared_backgrounds/create','create' )->name('shared_backgrounds.create');
        Route::post('shared_backgrounds/store','store' )->name('shared_backgrounds.store');
        Route::get('shared_backgrounds/delete/{id}','destroy' )->name('shared_backgrounds.delete');
        Route::get('shared_backgrounds/search/{section}','destroy' )->name('shared_backgrounds.search');
    });

   // Route::resource('shared_backgrounds',\App\Http\Controllers\Web\Admin\SharedBackgroundsController::class)->only(['index','store','destroy','create']);

    Route::controller(\App\Http\Controllers\Web\Admin\SectionKeywordController::class)->group(function (){
        Route::get('section_keywords/delete/{id}','destroy' )->name('section_keywords.delete');
    });
    Route::resource('section_keywords', \App\Http\Controllers\Web\Admin\SectionKeywordController::class)->only(['index','store','create',]);
    /**
     * Category Routes
     */
    Route::controller(\App\Http\Controllers\Web\Admin\CategoryController::class)->group(function (){
        Route::get('sections/{id}/categories','getCategoriesBySectionId')
            ->name('sections.categories.index');
    });
    Route::resource('categories', \App\Http\Controllers\Web\Admin\CategoryController::class)->except(['show']);

    /**
     * Content Routes
     */
    Route::controller(\App\Http\Controllers\Web\Admin\ContentController::class)->group(function (){
        Route::get('contents/{id}/margins','marginsIndex')
            ->name('contents.margins.index');
        Route::post('contents/{id}/voices/{type}/upload','upload')
            ->name('contents.voices.upload');
        Route::delete('contents/{id}/voices/{type}/delete','removeFile')
            ->name('contents.voices.delete');
        Route::resource('contents', \App\Http\Controllers\Web\Admin\ContentController::class);
    });

    /**
     * ParagraphController
     */
    Route::prefix('contents/{content_id}')->controller(\App\Http\Controllers\Web\Admin\ParagraphController::class)->group(function (){
        Route::get('paragraphs/create','create')->name('paragraphs.create');
        Route::post('paragraphs','store')->name('paragraphs.store');
        Route::get('paragraphs/{paragraph_id}/edit','edit')->name('paragraphs.edit');
        Route::put('paragraphs/{paragraph_id}','update')->name('paragraphs.update');
        Route::delete('paragraphs/{paragraph_id}','destroy')->name('paragraphs.destroy');
        Route::get('paragraphs/{paragraph_id}','show')->name('paragraphs.show');
        Route::put('paragraphs/{paragraph_id}/text','updateContent')->name('paragraphs.text.update');
    });


    Route::get('paragraphs/index',[\App\Http\Controllers\Web\Admin\ParagraphController::class,'index'])->name('paragraphs.index');
   // Route::resource('paragraphs', \App\Http\Controllers\Web\Admin\ParagraphController::class);

    Route::get('paragraph_keyword/delete/{id}',[App\Http\Controllers\Web\Admin\ParagraphKeywordController::class, 'destroy'])->name('paragraph_keyword.delete');
    Route::get('paragraphs/{paragraph_id}/paragraph_keyword/add/{keyword_id}',[App\Http\Controllers\Web\Admin\ParagraphKeywordController::class, 'store'])->name('paragraph_keyword.store');


    /**
     * Languages Routes
     */
    Route::resource('languages', \App\Http\Controllers\Web\Admin\LanguageController::class)->only(['index','store','destroy']);
    Route::get('languages/edit/{lang}',[\App\Http\Controllers\Web\Admin\LanguageController::class,'edit'])->name('language.edit');
    Route::post('languages/update/{lang}',[\App\Http\Controllers\Web\Admin\LanguageController::class,'update'])->name('language.update');

    /**
     * MarginController
     */
    Route::controller(\App\Http\Controllers\Web\Admin\MarginController::class)->group(function (){
        Route::post('sections/{id}/margins','store')->name('margins.store');
        Route::get('margins/{id}','edit')->name('margins.edit');
        Route::put('margins/{id}','update')->name('margins.update');
        Route::delete('margins/{id}','destroy')->name('margins.destroy');
    });


    /**
     * ContentMarginController
     */
    Route::controller(\App\Http\Controllers\Web\Admin\ContentMarginController::class)->group(function (){
        Route::get('contents/{content_id}/margins/{margin_id}','index')->name('content-margins.index');
        Route::post('contents/{content_id}/margins/{margin_id}','store')->name('content-margins.store');
        Route::delete('content-margins/{id}','destroy')->name('content-margins.destroy');
        Route::put('content-margins/{id}','update')->name('content-margins.update');
    });
});
