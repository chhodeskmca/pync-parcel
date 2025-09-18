<?php

/**
 * Simple file-based cache manager for API responses and frequently accessed data
 */
class CacheManager
{
    private $cache_dir;
    private $default_ttl;

    public function __construct($cache_dir = null, $default_ttl = 3600)
    {
        $this->cache_dir = $cache_dir ?: __DIR__ . '/cache';
        $this->default_ttl = $default_ttl;

        // Create cache directory if it doesn't exist
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0755, true);
        }
    }

    /**
     * Get cached data
     */
    public function get($key)
    {
        $file = $this->getCacheFile($key);

        if (!file_exists($file)) {
            return false;
        }

        $data = unserialize(file_get_contents($file));

        if (!$data || !isset($data['expires']) || time() > $data['expires']) {
            $this->delete($key);
            return false;
        }

        return $data['value'];
    }

    /**
     * Set cached data
     */
    public function set($key, $value, $ttl = null)
    {
        $ttl = $ttl ?: $this->default_ttl;
        $data = [
            'value' => $value,
            'expires' => time() + $ttl,
            'created' => time()
        ];

        $file = $this->getCacheFile($key);
        return file_put_contents($file, serialize($data)) !== false;
    }

    /**
     * Delete cached data
     */
    public function delete($key)
    {
        $file = $this->getCacheFile($key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }

    /**
     * Clear all cache
     */
    public function clear()
    {
        $files = glob($this->cache_dir . '/*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
        return true;
    }

    /**
     * Check if cache exists and is valid
     */
    public function has($key)
    {
        return $this->get($key) !== false;
    }

    /**
     * Get cache file path
     */
    private function getCacheFile($key)
    {
        return $this->cache_dir . '/' . md5($key) . '.cache';
    }

    /**
     * Get cache statistics
     */
    public function getStats()
    {
        $files = glob($this->cache_dir . '/*.cache');
        $stats = [
            'total_files' => count($files),
            'total_size' => 0,
            'valid_entries' => 0,
            'expired_entries' => 0
        ];

        foreach ($files as $file) {
            $stats['total_size'] += filesize($file);

            $data = unserialize(file_get_contents($file));
            if ($data && isset($data['expires'])) {
                if (time() > $data['expires']) {
                    $stats['expired_entries']++;
                } else {
                    $stats['valid_entries']++;
                }
            }
        }

        return $stats;
    }
}

/**
 * Rate limiter for API calls
 */
class RateLimiter
{
    private $cache;
    private $max_requests;
    private $window_seconds;

    public function __construct($max_requests = 100, $window_seconds = 60)
    {
        $this->cache = new CacheManager(__DIR__ . '/cache/rate_limit', $window_seconds);
        $this->max_requests = $max_requests;
        $this->window_seconds = $window_seconds;
    }

    /**
     * Check if request is allowed
     */
    public function isAllowed($identifier)
    {
        $key = 'rate_limit_' . $identifier;
        $requests = $this->cache->get($key);

        if ($requests === false) {
            $requests = [];
        }

        // Remove old requests outside the window
        $now = time();
        $requests = array_filter($requests, function($timestamp) use ($now) {
            return ($now - $timestamp) < $this->window_seconds;
        });

        if (count($requests) >= $this->max_requests) {
            return false;
        }

        // Add current request
        $requests[] = $now;
        $this->cache->set($key, $requests, $this->window_seconds);

        return true;
    }

    /**
     * Get remaining requests for the current window
     */
    public function getRemainingRequests($identifier)
    {
        $key = 'rate_limit_' . $identifier;
        $requests = $this->cache->get($key);

        if ($requests === false) {
            return $this->max_requests;
        }

        // Remove old requests outside the window
        $now = time();
        $requests = array_filter($requests, function($timestamp) use ($now) {
            return ($now - $timestamp) < $this->window_seconds;
        });

        return max(0, $this->max_requests - count($requests));
    }
}
