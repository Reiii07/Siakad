<?php

namespace App\Providers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Tugas;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.*', function ($view): void {
            $notifications = [];

            try {
                $overdueTasks = Tugas::where('deadline', '<', now())->count();
                $soonTasks = Tugas::whereBetween('deadline', [now(), now()->addDays(3)])->count();

                if ($overdueTasks > 0) {
                    $notifications[] = [
                        'key' => 'tasks-overdue-'.$overdueTasks,
                        'icon' => 'bi-clock-history',
                        'title' => 'Deadline tugas lewat',
                        'body' => $overdueTasks.' tugas sudah melewati deadline.',
                        'url' => route('admin.tugas.index'),
                    ];
                }

                if ($soonTasks > 0) {
                    $notifications[] = [
                        'key' => 'tasks-soon-'.$soonTasks,
                        'icon' => 'bi-clock',
                        'title' => 'Deadline tugas dekat',
                        'body' => $soonTasks.' tugas akan deadline dalam 3 hari.',
                        'url' => route('admin.tugas.index'),
                    ];
                }

                if (Mahasiswa::count() === 0) {
                    $notifications[] = [
                        'key' => 'mahasiswa-empty',
                        'icon' => 'bi-people',
                        'title' => 'Data mahasiswa kosong',
                        'body' => 'Tambahkan mahasiswa agar data akademik lengkap.',
                        'url' => route('admin.mahasiswa.create'),
                    ];
                }

                if (Dosen::count() === 0) {
                    $notifications[] = [
                        'key' => 'dosen-empty',
                        'icon' => 'bi-person-badge',
                        'title' => 'Data dosen kosong',
                        'body' => 'Tambahkan dosen sebelum membuat mata kuliah.',
                        'url' => route('admin.dosen.index'),
                    ];
                }

                if (MataKuliah::count() === 0) {
                    $notifications[] = [
                        'key' => 'mata-kuliah-empty',
                        'icon' => 'bi-book',
                        'title' => 'Data mata kuliah kosong',
                        'body' => 'Tambahkan mata kuliah untuk tugas dan absensi.',
                        'url' => route('admin.mata-kuliah.index'),
                    ];
                }
            } catch (Throwable) {
                $notifications = [];
            }

            $readNotifications = session('admin_read_notifications', []);
            $notifications = array_values(array_filter($notifications, function (array $notification) use ($readNotifications): bool {
                return ! in_array(Arr::get($notification, 'key'), $readNotifications, true);
            }));

            $view->with('adminNotifications', $notifications);
            $view->with('adminNotificationCount', count($notifications));
        });
    }
}
