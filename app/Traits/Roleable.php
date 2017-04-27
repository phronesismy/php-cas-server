<?php

namespace App\Traits;

use App\Permission;
use App\Role;
use Cache;

trait Roleable
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->whereName($role)->count() == 1;
    }

    public function hasRoles($roles)
    {
        return $this->roles()->whereName($roles)->count() > 0;
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->cachedPermissions());
    }

    public function hasPermissions($permissions = [])
    {
        return count(array_intersect($this->cachedPermissions(), $permissions)) > 0;
    }

    public function hasAllPermissions($permissions = [])
    {
        return count(array_intersect($this->cachedPermissions(), $permissions)) == count($permissions);
    }

    public function cachedPermissions()
    {
        if (!Cache::has($this->permissions_cache_key)) {
            $this->cachePermissions();
        }

        return Cache::get($this->permissions_cache_key);
    }

    public function cachePermissions()
    {
        if (Cache::has($this->permissions_cache_key)) {
            Cache::forget($this->permissions_cache_key);
        }

        $that = $this;
        Cache::rememberForever($this->permissions_cache_key, function () use ($that) {
            return Permission::join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
                                        ->whereIn('permission_role.role_id', $that->roles->pluck('id')->toArray())
                                        ->pluck('name')
                                        ->toArray();
        });
    }

    protected function getPermissionsCacheKeyAttribute()
    {
        return strtolower(getClass($this)) . 'permissions.' . $this->getKey();
    }
}