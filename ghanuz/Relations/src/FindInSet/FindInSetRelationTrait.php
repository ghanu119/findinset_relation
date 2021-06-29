<?php
namespace GhanuZ\FindInSet;

trait FindInSetRelationTrait {


     /**
     * Define a has many relation with null.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function FindInSetMany($related, $localKey = null, $foreignKey = null, $index = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new FindInSetMany(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey, $index
        );
    }

     /**
     * Define a has many relation with null.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function FindInSetOne($related, $localKey = null, $foreignKey = null, $index = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new FindInSetOne(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey, $index
        );
    }
}
